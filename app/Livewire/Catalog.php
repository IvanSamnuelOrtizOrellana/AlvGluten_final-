<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Layout;
#[Layout('components.layouts.app')]
class Catalog extends Component
{
    
    /*public function addToCart($productId)
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
    }*/
    public function addToCart(int $productId): void
    {
        if (!auth()->check()) {
            $this->dispatch('abrir-modal-login');
            return;
        }

        $user = auth()->user();
        $existing = $user->cartProducts()->where('product_id', $productId)->first();

        if ($existing) {
            // Producto ya en carrito → incrementa la cantidad en la pivote
            $user->cartProducts()->updateExistingPivot($productId, [
                'quantity' => $existing->pivot->quantity + 1,
            ]);
        } else {
            // Producto nuevo → lo agrega con quantity = 1 (default)
            $user->cartProducts()->attach($productId);
        }

        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.catalog', [
            'products' => Product::with('category')->get(),
        ]);
    }


}