
    <div>
        <h1 class="text-3xl font-extrabold text-gray-800 mb-8 border-b-2 border-lime-500 inline-block pb-2">Catálogo de Productos</h1>

        <div class="relative bg-white overflow-hidden rounded-3xl mb-12 shadow-xl border border-gray-100">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-lime-600 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-10 px-6 lg:px-8">
                    <main class="mt-10 mx-auto max-w-7xl sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                                <span class="block xl:inline">Prodúctos sin gluten para</span>
                                <span class="block text-yellow-300 xl:inline">celíacos no millonarios</span>
                            </h1>
                            <p class="mt-3 text-base text-white sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Disfruta del las mejor calidad y precio con ingredientes 100% libres de gluten y contaminación cruzada.
                            </p>
                            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-md shadow">
                                    <a href="#productos" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-lg text-lime-700 bg-white hover:bg-lime-50 md:py-4 md:text-lg transition-transform hover:scale-105">
                                        Ver Catálogo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-lime-700">
                <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full opacity-90 mix-blend-multiply" src="https://images.unsplash.com/photo-1606854428728-5fe3eea23475?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Supermercado sin gluten">
            </div>
        </div>

        <div id="productos" class="mb-8 border-b-2 border-gray-100 pb-4">
            <h2 class="text-3xl font-extrabold text-gray-900">Recién agregados</h2>
            <p class="text-gray-500 mt-2">Agrega tus snacks y comidas favoritas al carrito.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="w-full max-w-sm bg-white p-6 border border-gray-200 rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 flex flex-col group">

                    <a href="#" class="block h-48 bg-lime-50 rounded-xl mb-6 flex items-center justify-center text-7xl group-hover:scale-105 transition-transform duration-300">
                        🛍️
                    </a>

                    <div class="flex-grow flex flex-col">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-1">
                                <svg class="w-5 h-5 text-yellow-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/></svg>
                                <span class="text-sm font-bold text-gray-700 ml-1">5.0</span>
                            </div>
                            <span class="bg-lime-100 text-lime-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            {{ $product->category->name }}
                        </span>
                        </div>

                        <a href="#">
                            <h5 class="text-xl text-gray-900 font-extrabold tracking-tight leading-tight mb-4">
                                {{ $product->name }}
                            </h5>
                        </a>

                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-3xl font-black text-gray-900">${{ $product->price }}</span>

                            <button wire:click="addToCart({{ $product->id }})" type="button" class="inline-flex items-center text-white bg-lime-600 hover:bg-lime-700 focus:ring-4 focus:ring-lime-300 font-bold rounded-lg text-sm px-4 py-2.5 focus:outline-none transition-colors shadow-md">
                                <svg class="w-5 h-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                                </svg>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
