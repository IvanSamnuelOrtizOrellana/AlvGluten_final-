<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin · AlvGluten</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 font-sans antialiased">

<aside class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-white flex flex-col z-40">
    <div class="p-5 border-b border-gray-700">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo_alvgluten.png') }}"
                 alt="AlvGluten" class="h-18 object-contain brightness-200">
        </a>
        <span class="block text-xs text-gray-400 mt-1 font-mono">Panel Administrador</span>
    </div>

    <nav class="flex-1 p-4 space-y-1">
        <a href="{{ route('admin.productos.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                  {{ request()->routeIs('admin.productos*') ? 'bg-lime-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
            Productos
        </a>
    </nav>

    <div class="p-4 border-t border-gray-700">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-8 bg-lime-600 rounded-full flex items-center justify-center font-bold text-sm">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-400">Administrador</p>
            </div>
        </div>
        <a href="{{ route('home') }}"
           class="block text-center text-xs text-gray-400 hover:text-white transition-colors py-1">
            ← Volver a la tienda
        </a>
    </div>
</aside>

<main class="ml-64 min-h-screen">
    {{ $slot }}
</main>

@livewireScripts
</body>
</html>