<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    <h1 class="text-3xl font-extrabold text-gray-800 mb-8 border-b-2 border-orange-500 inline-block pb-2">Catálogo de Productos</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="bg-white border rounded-xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col">
                <!-- Imagen Falsa del pan -->
                <div class="h-48 bg-orange-100 flex items-center justify-center text-6xl">
                    🥖
                </div>

                <!-- Detalles del producto -->
                <div class="p-4 flex flex-col flex-grow">
                    <span class="text-xs font-semibold text-orange-500 uppercase tracking-wider mb-1">{{ $product->category->name }}</span>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $product->name }}</h2>

                    <div class="mt-auto flex justify-between items-center">
                        <p class="text-2xl font-black text-green-600">${{ $product->price }}</p>
                        <!-- Este botón todavía no hace nada, lo conectaremos al Carrito después -->
                        <button wire:click="addToCart({{ $product->id }})" class="bg-black text-white w-8 h-8 rounded-full font-bold hover:bg-gray-800 transition">
                            +
                        </button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>