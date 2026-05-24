<?php

use App\Livewire\Catalog;
use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Livewire\Admin\ProductIndex;
use App\Livewire\Admin\ProductCreate;
use App\Livewire\Admin\ProductEdit;
use App\Livewire\Checkout;
use App\Livewire\MisPedidos;


// Catálogo Perrón como página principal
Route::get('/', Catalog::class)->name('home');

// El Dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Tus rutas de Google Auth
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);


Route::post('/logout', function(Request $request){
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');
Route::get('/cart/count', function () {
    return response()->json([
        'count' => auth()->check()
            ? auth()->user()->cartProducts()->sum('product_user.quantity')
            : 0
    ]);
})->middleware('auth');

// Grupo protegido: debe estar autenticado Y ser admin
Route::middleware(['auth', 'es-admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', fn() => redirect()->route('admin.productos.index'))
            ->name('dashboard');


        Route::get('/productos',        ProductIndex::class)->name('productos.index');
        Route::get('/productos/crear',  ProductCreate::class)->name('productos.crear');
        Route::get('/productos/{product}/editar', ProductEdit::class)->name('productos.editar');
    });
// checkout
Route::middleware('auth')->group(function () {
    Route::get('/checkout', Checkout::class)->name('checkout');
    Route::get('/checkout/exito', fn() => view('livewire.checkout-exito'))
        ->name('checkout.exito');
    Route::get('/mis-pedidos', MisPedidos::class)->name('mis-pedidos');
});

require __DIR__.'/auth.php';