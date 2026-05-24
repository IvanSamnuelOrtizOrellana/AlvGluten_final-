<div class="p-8 max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.productos.index') }}"
           class="text-gray-400 hover:text-gray-700 transition-colors font-medium text-sm">
            ← Volver al listado
        </a>
        <span class="text-gray-300">/</span>
        <h1 class="text-2xl font-extrabold text-gray-900 truncate">
            Editar: {{ $product->name }}
        </h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre del producto</label>
            <input wire:model="name" type="text"
                   class="w-full border-gray-200 rounded-xl focus:border-lime-400 focus:ring-lime-400">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
            <textarea wire:model="description" rows="3"
                      class="w-full border-gray-200 rounded-xl focus:border-lime-400 focus:ring-lime-400"></textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Precio (MXN)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-sm pointer-events-none">$</span>
                    <input wire:model="price" type="number" step="0.01"
                           class="w-full pl-7 border-gray-200 rounded-xl focus:border-lime-400 focus:ring-lime-400">
                </div>
                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Categoría</label>
                <select wire:model="category_id"
                        class="w-full border-gray-200 rounded-xl focus:border-lime-400 focus:ring-lime-400">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Imagen: muestra actual + opción de reemplazar --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Imagen</label>

            @if($imagen)
                <div class="mb-3 flex items-center gap-3">
                    <img src="{{ $imagen->temporaryUrl() }}"
                         class="h-24 w-24 object-cover rounded-xl border-2 border-lime-300">
                    <div>
                        <p class="text-xs text-lime-600 font-semibold">✓ Nueva imagen lista</p>
                        <p class="text-xs text-gray-400 mt-0.5">Reemplazará la imagen actual al guardar</p>
                    </div>
                </div>
            @elseif($product->image_path)
                <div class="mb-3 flex items-center gap-3">
                    <img src="{{ $product->image_url }}"
                         class="h-24 w-24 object-cover rounded-xl border border-gray-200">
                    <p class="text-xs text-gray-400">Imagen actual · sube una nueva para reemplazarla</p>
                </div>
            @endif

            <input wire:model="imagen" type="file" accept="image/*"
                   class="block w-full text-sm text-gray-500
                          file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0
                          file:bg-lime-50 file:text-lime-700 file:font-semibold
                          hover:file:bg-lime-100 cursor-pointer">

            <div wire:loading wire:target="imagen" class="mt-2 text-xs text-lime-600 font-medium">
                ⏳ Cargando imagen...
            </div>

            @error('imagen') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3 p-3 bg-lime-50 rounded-xl">
            <input wire:model="is_gluten_free" id="igf_edit" type="checkbox"
                   class="w-5 h-5 rounded text-lime-600 focus:ring-lime-500">
            <label for="igf_edit" class="text-sm font-semibold text-gray-700 cursor-pointer">
                🌾 Certificado Sin Gluten
            </label>
        </div>

        <button wire:click="update"
                wire:loading.attr="disabled"
                wire:target="update"
                class="w-full bg-lime-600 hover:bg-lime-700 disabled:opacity-60 text-white font-bold py-3 px-6 rounded-xl shadow transition-all active:scale-95">
            <span wire:loading.remove wire:target="update">Guardar Cambios</span>
            <span wire:loading wire:target="update">⏳ Guardando...</span>
        </button>
    </div>
</div>