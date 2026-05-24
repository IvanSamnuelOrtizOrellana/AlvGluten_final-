<div class="p-8">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Productos</h1>
            <p class="text-sm text-gray-500 mt-0.5">Gestiona el catálogo de AlvGluten</p>
        </div>
        <a href="{{ route('admin.productos.crear') }}"
           class="flex items-center gap-2 bg-lime-600 hover:bg-lime-700 text-white font-bold px-4 py-2.5 rounded-xl shadow transition-all">
            + Nuevo Producto
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-lime-50 border border-lime-200 text-lime-800 rounded-xl px-4 py-3 text-sm font-medium">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Filtros --}}
        <div class="p-4 border-b border-gray-100 flex items-center gap-4">
            <input wire:model.live.debounce.300ms="search"
                   type="text"
                   placeholder="Buscar producto..."
                   class="flex-1 border-gray-200 rounded-xl text-sm focus:border-lime-400 focus:ring-lime-400">

            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none whitespace-nowrap">
                <input wire:model.live="mostrarEliminados" type="checkbox"
                       class="rounded text-lime-600 focus:ring-lime-500">
                Mostrar eliminados
            </label>
        </div>

        {{-- Tabla --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                <tr>
                    <th class="px-4 py-3 text-left">Producto</th>
                    <th class="px-4 py-3 text-left">Categoría</th>
                    <th class="px-4 py-3 text-right">Precio</th>
                    <th class="px-4 py-3 text-center">Sin Gluten</th>
                    <th class="px-4 py-3 text-center">Estado</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($this->products as $product)
                    <tr class="{{ $product->trashed() ? 'bg-red-50 opacity-60' : 'hover:bg-gray-50' }} transition-colors">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->image_url }}"
                                     class="w-10 h-10 rounded-lg object-cover border border-gray-100 flex-shrink-0"
                                     alt="{{ $product->name }}">
                                <span class="font-medium text-gray-900 truncate max-w-[180px]">
                                        {{ $product->name }}
                                    </span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ $product->category->name ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-right font-bold text-gray-900">
                            ${{ number_format($product->price, 2) }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($product->is_gluten_free)
                                <span class="bg-lime-100 text-lime-700 text-xs font-bold px-2 py-0.5 rounded-full">✓ GF</span>
                            @else
                                <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-0.5 rounded-full">✗ No</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($product->trashed())
                                <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-0.5 rounded-full">Eliminado</span>
                            @else
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-0.5 rounded-full">Activo</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                @if($product->trashed())
                                    <button wire:click="restore({{ $product->id }})"
                                            class="text-xs bg-lime-100 hover:bg-lime-200 text-lime-700 font-bold px-3 py-1.5 rounded-lg transition-colors">
                                        Restaurar
                                    </button>
                                    <button wire:click="forceDelete({{ $product->id }})"
                                            wire:confirm="⚠️ Esto es PERMANENTE e irreversible. ¿Continuar?"
                                            class="text-xs bg-red-100 hover:bg-red-200 text-red-700 font-bold px-3 py-1.5 rounded-lg transition-colors">
                                        Borrar para siempre
                                    </button>
                                @else
                                    <a href="{{ route('admin.productos.editar', $product) }}"
                                       class="text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 font-bold px-3 py-1.5 rounded-lg transition-colors">
                                        Editar
                                    </a>
                                    <button wire:click="softDelete({{ $product->id }})"
                                            wire:confirm="¿Eliminar '{{ $product->name }}'? Se puede restaurar después."
                                            class="text-xs bg-red-100 hover:bg-red-200 text-red-700 font-bold px-3 py-1.5 rounded-lg transition-colors">
                                        Eliminar
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-16 text-center text-gray-400">
                            <span class="text-5xl block mb-3">📦</span>
                            <p class="font-medium">No hay productos{{ $search ? ' que coincidan' : '' }}.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $this->products->links() }}
        </div>
    </div>
</div>