<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AlvGluten | El paraíso sin gluten</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_alvgluten.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
<div class="min-h-screen flex flex-col">

    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo_alvgluten.png') }}" alt="Logo AlvGluten" class="h-24 w-auto max-w-[160px] sm:h-14 sm:max-w-[200px] object-contain transition-transform group-hover:scale-105">

                    </a>
                </div>
                <div class="flex items-center space-x-3 sm:space-x-6">

                    @auth
                        <button type="button" data-drawer-target="drawer-cart" data-drawer-show="drawer-cart" data-drawer-placement="right" class="relative text-gray-700 hover:text-lime-600 transition-colors focus:outline-none">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span id="cart-counter" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full border-2 border-white">
                                 {{ auth()->user()->cartProducts()->sum('product_user.quantity') }}
                            </span>
                        </button>

                        <button id="dropdownUserButton" data-dropdown-toggle="dropdownUser" class="flex items-center gap-2 text-gray-700 hover:text-lime-600 font-bold transition-colors focus:outline-none" type="button">
                            <span class="hidden sm:block">Hola, {{ explode(' ', auth()->user()->name)[0] }}</span>
                            <span class="sm:hidden">Menú</span>
                            <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                        </button>
                        <div id="dropdownUser" class="z-50 hidden bg-white divide-y divide-gray-100 rounded-xl shadow-lg w-44 border border-gray-100">
                            <ul class="py-2 text-sm text-gray-700">
                                <li><a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-lime-50 hover:text-lime-600 font-medium">Mi Panel</a></li>
                            </ul>
                            <div class="py-2">
                                <button
                                        wire:click="$dispatch('logout-requested')"
                                        onclick="document.getElementById('logout-form').submit()"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">
                                    Cerrar Sesión
                                </button>


                                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>

                    @else
                        <button type="button" data-modal-target="login-modal" data-modal-toggle="login-modal" class="relative text-gray-700 hover:text-lime-600 transition-colors focus:outline-none">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </button>

                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-lime-600 font-bold transition-colors">Entrar</a>
                        <a href="{{ route('register') }}" class="hidden sm:block bg-lime-500 text-white hover:bg-lime-600 px-5 py-2.5 rounded-lg font-bold transition-colors shadow-md text-sm">Crear Cuenta</a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col">
        {{ $slot }}
    </main>

    <footer class="bg-white rounded-2xl shadow-sm border border-gray-200 m-4 mt-auto">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-gray-500 sm:text-center">© {{ date('Y') }} <a href="/" class="hover:underline text-lime-600 font-bold">AlvGluten™</a>. Todos los derechos reservados.</span>
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 sm:mt-0">
                <li><a href="#" class="hover:underline me-4 md:me-6 hover:text-lime-600 transition-colors">Sobre Nosotros</a></li>
                <li><a href="#" class="hover:underline me-4 md:me-6 hover:text-lime-600 transition-colors">Políticas de Privacidad</a></li>
                <li><a href="#" class="hover:underline hover:text-lime-600 transition-colors">Contacto</a></li>
            </ul>
        </div>
    </footer>

    @guest
        <div id="login-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[70] justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100">
                    <div class="p-4 md:p-5 text-center">
                        <span class="text-6xl mb-4 block">🔒</span>
                        <h3 class="mb-2 text-xl font-bold text-gray-900">¡Inicia sesión primero!</h3>
                        <p class="text-sm text-gray-500 mb-6">Para poder armar tu súper sin gluten y agregar productos al carrito, necesitas entrar a tu cuenta.</p>
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('login') }}" class="text-white bg-lime-600 hover:bg-lime-700 focus:ring-4 focus:outline-none focus:ring-lime-300 font-bold rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center transition-colors">
                                Ir a Iniciar Sesión
                            </a>
                            <button id="btn-cancelar-modal" type="button" class="py-2.5 px-5 text-sm font-bold text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-lime-700 transition-colors">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endguest

    @auth
        <div id="drawer-cart" class="fixed top-0 right-0 z-[60] h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 sm:w-96 border-l border-gray-200 shadow-2xl" tabindex="-1">
            <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-4">
                <h5 class="inline-flex items-center text-lg font-extrabold text-gray-900">🛒 Tu Carrito</h5>
                <button type="button" data-drawer-hide="drawer-cart" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex items-center justify-center transition-colors">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                </button>
            </div>

            <div class="py-4 flex flex-col h-[calc(100vh-120px)]">

                <livewire:cart-drawer />
            </div>

                <div class="mt-auto pt-4 border-t border-gray-200">
                    <div class="flex justify-between mb-4">
                        <span class="font-bold text-gray-900">Total a pagar:</span>
                        <span class="font-black text-lime-600 text-xl">
                        ${{ number_format(auth()->user()->cartProducts->sum('price'), 2) }}
                    </span>
                    </div>
                    <a href="#" class="block text-center w-full text-white bg-lime-600 hover:bg-lime-700 focus:ring-4 focus:ring-lime-300 font-bold rounded-lg text-sm px-4 py-3 shadow-md transition-colors">
                        Ir a Pagar
                    </a>
                </div>
            </div>
        </div>
    @endauth

</div>

<script>
    document.addEventListener('livewire:initialized', () => {

        Livewire.hook('request', ({ options }) => {
            options.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        });

        // ... resto de tus listeners
    });
    document.addEventListener('livewire:initialized', () => {
        const $modalEl = document.getElementById('login-modal');
        let loginModal = null;

        // Inicializa la instancia de Flowbite una sola vez
        if ($modalEl) {
            loginModal = new Modal($modalEl, { backdrop: 'dynamic' });
        }


        Livewire.on('abrir-modal-login', () => {
            loginModal?.show();
        });

        // Botón cancelar: cierra usando la misma instancia
        document.getElementById('btn-cancelar-modal')?.addEventListener('click', () => {
            loginModal?.hide();
        });

        // Bug 2 fix: actualiza el contador del carrito
        Livewire.on('cart-counter-sync', () => {
            // Re-fetch el conteo real desde el servidor
            fetch('/cart/count')
                .then(r => r.json())
                .then(data => {
                    const counter = document.getElementById('cart-counter');
                    if (counter) counter.innerText = data.count;
                });
        });
    });
</script>
</body>
</html>