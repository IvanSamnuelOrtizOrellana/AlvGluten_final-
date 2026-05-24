<div class="max-w-3xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Mis Pedidos 📦</h1>

    @forelse($orders as $order)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-4 overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <div>
                    <span class="font-bold text-gray-900">Pedido #{{ $order->id }}</span>
                    <span class="ml-3 text-sm text-gray-400">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="bg-{{ $order->statusColor() }}-100 text-{{ $order->statusColor() }}-700 text-xs font-bold px-3 py-1 rounded-full capitalize">
                        {{ $order->status }}
                    </span>
                    <span class="font-black text-lime-600">
                        ${{ number_format($order->total, 2) }}
                    </span>
                </div>
            </div>
            <div class="p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">
                    {{ $order->items->count() }} {{ Str::plural('producto', $order->items->count()) }}
                </p>
                <div class="space-y-1">
                    @foreach($order->items as $item)
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>{{ $item->product_name }}
                                <span class="text-gray-400">× {{ $item->quantity }}</span>
                            </span>
                            <span class="font-medium">${{ number_format($item->subtotal, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-20 text-gray-400">
            <span class="text-6xl block mb-4">📭</span>
            <p class="font-medium">Todavía no tienes pedidos.</p>
            <a href="{{ route('home') }}"
               class="inline-block mt-4 bg-lime-600 text-white font-bold px-6 py-2.5 rounded-xl hover:bg-lime-700 transition-all">
                Ir al catálogo
            </a>
        </div>
    @endforelse

    <div class="mt-4">{{ $orders->links() }}</div>
</div>