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
}