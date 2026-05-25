<?php

namespace Tests\Feature;

use App\Livewire\Admin\ProductCreate;
use App\Livewire\Admin\ProductIndex;
use App\Livewire\Catalog;
use App\Livewire\Checkout;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AlvGlutenTest extends TestCase
{
    // RefreshDatabase: antes de cada test, resetea la DB completa.
    // Usa una DB de prueba separada (definida en phpunit.xml)
    use RefreshDatabase;

    // =========================================================
    // HELPERS PRIVADOS — evitan repetir código en cada test
    // =========================================================

    private function crearAdmin(): User
    {
        return User::factory()->create([
            'rol' => User::ROLE_ADMIN,
            'email_verified_at' => now(),
        ]);
    }

    private function crearUsuario(): User
    {
        return User::factory()->create([
            'rol' => User::ROLE_USER,
            'email_verified_at' => now(),
        ]);
    }

    private function crearProducto(): Product
    {
        $category = Category::factory()->create();
        return Product::factory()->create([
            'category_id' => $category->id,
        ]);
    }

    // =========================================================
    // TEST 1 — Ruta pública → 200 + texto visible
    // Rúbrica: "al consultar ruta Y, aseguro código 200 y texto determinado"
    // =========================================================
    public function test_catalogo_carga_para_usuarios_autenticados(): void
    {
        $user = $this->crearUsuario();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSeeLivewire(Catalog::class);
    }

    public function test_panel_admin_carga_para_administradores(): void
    {
        $admin = $this->crearAdmin();
        $this->crearProducto(); // necesitamos al menos un producto en la tabla

        $response = $this->actingAs($admin)->get('/admin/productos');

        $response->assertStatus(200);
        $response->assertSeeLivewire(ProductIndex::class);
    }

    public function test_panel_admin_deniega_acceso_a_usuarios_normales(): void
    {
        $usuario = $this->crearUsuario();

        $response = $this->actingAs($usuario)->get('/admin/productos');

        // El middleware EsAdmin devuelve 403 si no eres admin
        $response->assertStatus(403);
    }

    public function test_checkout_redirige_a_invitados_al_login(): void
    {
        // Sin actingAs = usuario no autenticado (guest)
        $response = $this->get('/checkout');

        $response->assertRedirect('/login');
    }

    // =========================================================
    // TEST 2 — POST → registro creado en DB + redirect
    // Rúbrica: "al enviar petición POST, aseguro creación de registro en DB"
    // =========================================================
    public function test_admin_puede_crear_producto(): void
    {
        $admin    = $this->crearAdmin();
        $category = Category::factory()->create();

        // Fakeamos el disco de storage para no tocar archivos reales
        Storage::fake('public');

        Livewire::actingAs($admin)
            ->test(ProductCreate::class)
            ->set('name', 'Galletas Sin Gluten AlvGluten')
            ->set('description', 'Galletas crujientes certificadas sin gluten para celíacos')
            ->set('price', '89.50')
            ->set('category_id', (string) $category->id)
            ->set('is_gluten_free', true)
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.productos.index'));

        // Verifica que el registro existe en la DB
        $this->assertDatabaseHas('products', [
            'name'  => 'Galletas Sin Gluten AlvGluten',
            'price' => '89.50',
        ]);
    }

    public function test_checkout_crea_orden_y_vacia_carrito(): void
    {
        Mail::fake(); // Evita enviar correos reales durante el test

        $usuario  = $this->crearUsuario();
        $producto = $this->crearProducto();

        // Agregamos el producto al carrito con cantidad 2
        $usuario->cartProducts()->attach($producto->id, ['quantity' => 2]);

        Livewire::actingAs($usuario)
            ->test(Checkout::class)
            ->call('confirmarOrden')
            ->assertRedirect(route('checkout.exito'));

        // La orden se creó en la DB
        $this->assertDatabaseHas('orders', [
            'user_id' => $usuario->id,
            'status'  => 'confirmado',
        ]);

        // Los items de la orden se guardaron con snapshot de precio
        $order = Order::where('user_id', $usuario->id)->first();
        $this->assertDatabaseHas('order_items', [
            'order_id'     => $order->id,
            'product_name' => $producto->name,
            'quantity'     => 2,
        ]);

        // El carrito quedó vacío
        $this->assertDatabaseMissing('product_user', [
            'user_id' => $usuario->id,
        ]);

        // El correo se intentó enviar al email correcto
        Mail::assertSent(\App\Mail\ConfirmacionPedido::class, function ($mail) use ($usuario) {
            return $mail->hasTo($usuario->email);
        });
    }

    // =========================================================
    // TEST 3 — POST inválido → errores de validación
    // Rúbrica: "al enviar POST con info incorrecta, asegurar error en validación"
    // =========================================================
    public function test_crear_producto_falla_con_datos_invalidos(): void
    {
        $admin = $this->crearAdmin();

        Livewire::actingAs($admin)
            ->test(ProductCreate::class)
            ->set('name', '')           // requerido — vacío
            ->set('description', 'x')  // mínimo 10 chars — muy corto
            ->set('price', '-5')        // mínimo 0.01 — negativo
            ->set('category_id', '999') // no existe en la tabla categories
            ->call('save')
            ->assertHasErrors([
                'name',
                'description',
                'price',
                'category_id',
            ]);

        // Ningún producto se creó en la DB
        $this->assertDatabaseCount('products', 0);
    }

    public function test_crear_producto_requiere_ser_admin(): void
    {
        $usuario  = $this->crearUsuario();
        $category = Category::factory()->create();

        // Un usuario normal intenta crear un producto


        Livewire::actingAs($usuario)
            ->test(ProductCreate::class)
            ->set('name', 'Producto pirata')
            ->set('description', 'Descripción larga suficiente aquí')
            ->set('price', '50')
            ->set('category_id', (string) $category->id)
            ->call('save')
            ->assertForbidden(); // para verificar el error 403

        $this->assertDatabaseMissing('products', ['name' => 'Producto pirata']); //
    }

    // =========================================================
    // TEST 4 — DELETE → eliminado de DB + redirect
    // Rúbrica: "al enviar DELETE, aseguro eliminación de registro"
    // =========================================================
    public function test_admin_puede_hacer_soft_delete_de_producto(): void
    {
        $admin    = $this->crearAdmin();
        $producto = $this->crearProducto();

        Livewire::actingAs($admin)
            ->test(ProductIndex::class)
            ->call('softDelete', $producto->id);

        // assertSoftDeleted verifica que deleted_at no sea null
        // El registro EXISTE en la DB pero con deleted_at seteado
        $this->assertSoftDeleted('products', ['id' => $producto->id]);
    }

    public function test_admin_puede_restaurar_producto_eliminado(): void
    {
        $admin    = $this->crearAdmin();
        $producto = $this->crearProducto();
        $producto->delete(); // soft delete manual para preparar el test

        Livewire::actingAs($admin)
            ->test(ProductIndex::class)
            ->call('restore', $producto->id);

        // Después del restore, deleted_at debe ser null
        $this->assertDatabaseHas('products', [
            'id'         => $producto->id,
            'deleted_at' => null,
        ]);
    }

    public function test_admin_puede_borrar_producto_permanentemente(): void
    {
        $admin    = $this->crearAdmin();
        $producto = $this->crearProducto();
        $producto->delete(); // soft delete primero

        Storage::fake('public');

        Livewire::actingAs($admin)
            ->test(ProductIndex::class)
            ->call('forceDelete', $producto->id);

        // assertDatabaseMissing verifica que el registro NO existe
        $this->assertDatabaseMissing('products', ['id' => $producto->id]);
    }
} 