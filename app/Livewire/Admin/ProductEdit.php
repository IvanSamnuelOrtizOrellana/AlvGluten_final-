<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.admin')]
class ProductEdit extends Component
{
    use WithFileUploads;

    // Route Model Binding: Livewire inyecta el Product automáticamente
    // desde la URL /admin/productos/{product}/editar
    public Product $product;

    #[Validate('required|string|min:3|max:255')]
    public string $name = '';

    #[Validate('required|string|min:10')]
    public string $description = '';

    #[Validate('required|numeric|min:0.01')]
    public string $price = '';

    #[Validate('required|exists:categories,id')]
    public string $category_id = '';

    #[Validate('boolean')]
    public bool $is_gluten_free = true;

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $imagen = null;

    // mount() corre UNA sola vez al inicializar el componente
    // Aquí poblamos las propiedades con los datos actuales del producto
    public function mount(Product $product): void
    {
        $this->product      = $product;
        $this->name         = $product->name;
        $this->description  = $product->description;
        $this->price        = (string) $product->price;
        $this->category_id  = (string) $product->category_id;
        $this->is_gluten_free = (bool) $product->is_gluten_free;
    }

    public function update(): void
    {
        Gate::authorize('es-admin');
        $this->validate();

        $imagePath = $this->product->image_path;

        if ($this->imagen) {
            // Elimina la imagen vieja del disco antes de guardar la nueva
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $this->imagen->store('products', 'public');
        }

        $this->product->update([
            'name'           => $this->name,
            'description'    => $this->description,
            'price'          => $this->price,
            'category_id'    => $this->category_id,
            'is_gluten_free' => $this->is_gluten_free,
            'image_path'     => $imagePath,
        ]);

        session()->flash('success', "Producto \"{$this->name}\" actualizado correctamente.");
        $this->redirect(route('admin.productos.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.product-edit', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}