<div class="max-w-2xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Confirmar Pedido 🛒</h1>
    <p class="text-gray-500 mb-8">Revisa tu pedido antes de confirmar.</p>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-5 border-b border-gray-100">
            <h2 class="font-bold text-gray-700 text-sm uppercase tracking-wide">Tus productos</h2>
        </div>

        <div class="divide-y divide-gray-100">
            @foreach($items as $item)
                <div class="flex items-center gap-4 p-4">
                    <img src="{{ $item->image_url }}"
                         class="w-14 h-14 rounded-xl object-cover border border-gray-100 flex-shrink-0"
                         alt="{{ $item->name }}">
                    <div class="flex-grow min-w-0">
                        <p class="font-bold text-gray-900 truncate">{{ $item->name }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $item->category->name ?? '' }} ·
                            {{ $item->pivot->quantity }} {{ Str::plural('pieza', $item->pivot->quantity) }}
                        </p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="font-black text-gray-900">
                            ${{ number_format($item->price * $item->pivot->quantity, 2) }}
                        </p>
                        <p class="text-xs text-gray-400">
                            ${{ number_format($item->price, 2) }} c/u
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="p-5 bg-gray-50 border-t border-gray-100">
            <div class="flex justify-between items-center">
                <span class="font-bold text-gray-700">Total a pagar:</span>
                <span class="text-2xl font-black text-lime-600">
                    ${{ number_format($total, 2) }} MXN
                </span>
            </div>
        </div>
    </div>

    {{-- Aviso de correo --}}
    <div class="flex items-start gap-3 bg-lime-50 border border-lime-200 rounded-xl p-4 mb-6">
        <span class="text-2xl">📧</span>
        <div>
            <p class="text-sm font-bold text-lime-800">Recibirás un correo de confirmación</p>
            <p class="text-xs text-lime-700 mt-0.5">
                Te enviaremos el resumen de tu pedido a
                <strong>{{ auth()->user()->email }}</strong>
            </p>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('home') }}"
           class="flex-1 text-center border-2 border-gray-200 hover:border-gray-300 text-gray-600 font-semibold py-3 px-6 rounded-xl transition-all">
            ← Seguir comprando
        </a>

        <button wire:click="confirmarOrden"
                wire:loading.attr="disabled"
                wire:confirm="¿Confirmar tu pedido por ${{ number_format($total, 2) }} MXN?"
                class="flex-1 bg-lime-600 hover:bg-lime-700 disabled:opacity-60 text-white font-bold py-3 px-6 rounded-xl shadow-md transition-all active:scale-95">
            <span wire:loading.remove wire:target="confirmarOrden">
                ✅ Confirmar y Pagar
            </span>
            <span wire:loading wire:target="confirmarOrden">
                ⏳ Procesando pedido...
            </span>
        </button>
    </div>
</div>