<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

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
        return redirect()->route('login');
    }
    //Agarra el ID de usuario y del producto para la tabla pivote, tambien
    // se uso syncWithoutDetaching para que si el usuario seleciono dos veces el mismo producto no marque error
    auth()->user()->cartProducts()->syncWithoutDetaching([$productId]);

    }

}