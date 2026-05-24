
<div>
    @if($items->isEmpty())
        <div class="flex flex-col items-center justify-center text-center h-64 opacity-60">
            <span class="text-6xl mb-4">🛍️</span>
            <p class="text-gray-500 font-medium">Tu carrito está muy vacío.</p>
            <p class="text-sm text-gray-400 mt-1">¡Agrega unos snacks deliciosos!</p>
        </div>
    @else
        <div class="flex-grow overflow-y-auto pr-1 space-y-3 max-h-[50vh]">
            @foreach($items as $item)
                <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-xl border border-gray-100">
                    {{-- Imagen del producto --}}
                    <div class="h-12 w-12 bg-lime-100 rounded-lg flex items-center justify-center text-xl flex-shrink-0">
                        @if($item->image_path)
                            <img src="{{ Storage::url($item->image_path) }}" class="h-full w-full object-cover rounded-lg" alt="{{ $item->name }}">
                        @else
                            🥖
                        @endif
                    </div>

                    <div class="flex-grow min-w-0">
                        <h6 class="text-sm font-bold text-gray-900 truncate">{{ $item->name }}</h6>
                        <p class="text-xs text-gray-500">{{ $item->category->name ?? '' }}</p>

                        {{-- Controles de cantidad --}}
                        <div class="flex items-center gap-2 mt-1.5">
                            <button wire:click="decrement({{ $item->id }})"
                                    class="w-6 h-6 rounded-full bg-gray-200 hover:bg-lime-200 text-gray-700 font-bold text-sm flex items-center justify-center transition-colors leading-none">
                                −
                            </button>
                            <span class="text-sm font-bold text-gray-800 w-4 text-center">{{ $item->pivot->quantity }}</span>
                            <button wire:click="increment({{ $item->id }})"
                                    class="w-6 h-6 rounded-full bg-gray-200 hover:bg-lime-200 text-gray-700 font-bold text-sm flex items-center justify-center transition-colors leading-none">
                                +
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col items-end gap-2 flex-shrink-0">
                        <span class="font-black text-lime-600 text-sm">
                            ${{ number_format($item->price * $item->pivot->quantity, 2) }}
                        </span>
                        {{-- Botón eliminar --}}
                        <button wire:click="remove({{ $item->id }})"
                                wire:confirm="¿Quitar {{ $item->name }} del carrito?"
                                class="text-red-400 hover:text-red-600 transition-colors"
                                title="Eliminar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Total y checkout --}}
        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex justify-between items-center mb-1">
                <span class="text-sm text-gray-500">{{ $totalItems }} {{ Str::plural('producto', $totalItems) }}</span>
                <span class="text-xs text-gray-400">sin impuestos</span>
            </div>
            <div class="flex justify-between items-center mb-4">
                <span class="font-bold text-gray-900">Total:</span>
                <span class="font-black text-lime-600 text-xl">${{ number_format($total, 2) }}</span>
            </div>
            <a href="{{ route('checkout') }}"
               class="block text-center w-full text-white bg-lime-600 hover:bg-lime-700 font-bold rounded-xl text-sm px-4 py-3 shadow-md transition-colors">
                Proceder al Pago →
            </a>
            <p class="text-center text-xs text-gray-400 mt-2">🛡️ Compra 100% segura</p>
        </div>
    @endif
</div>