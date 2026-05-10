<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Layout;
#[Layout('components.layouts.app')]
class Catalog extends Component
{
    public function render()
    {
        // Traemos todos los productos con su categoría
        $products = Product::with('category')->get();

        return view('livewire.catalog', compact('products'));
    }
    public function addToCart($productId)
    {
    if (!auth()->check())
    {
        //valida sí eel usuario inicio sesión con google o breeze, si no lo manda a iniciar sesíón o registrarse
        $this->dispatch('abrir-modal-login');
        // para el pop-up de inicio de sesion
        return;


    }
        $user = auth()->user();
    //Agarra el ID de usuario y del producto para la tabla pivote, tambien
    // se uso syncWithoutDetaching para que si el usuario seleciono dos veces el mismo producto no marque error
    //auth()->user()->cartProducts()->syncWithoutDetaching([$productId]);

    //revisa si el producto ya esta en el carrito para que no se sume
        if (!$user->cartProducts()->where('product_id', $productId)->exists()) {
            $user->cartProducts()->attach($productId);

            // para que no estar recargando para ver que se actualize el carrrito
            $this->dispatch('cart-updated');
        }
    }


}