<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'AlvGluten') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-gradient-to-br from-lime-50 via-green-50 to-emerald-100 font-sans antialiased">

{{-- Decoración de fondo --}}
<div class="fixed inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-lime-200 rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-green-300 rounded-full opacity-20 blur-3xl"></div>
</div>

<div class="relative min-h-screen flex flex-col items-center justify-center p-4">

    {{-- Logo siempre visible arriba --}}
    <a href="{{ route('home') }}" class="mb-6 block">
        <img src="{{ asset('images/logo_alvgluten.png') }}"
             alt="AlvGluten"
             class="h-16 object-contain mx-auto hover:scale-105 transition-transform">
    </a>

    {{-- Contenido de la página --}}
    {{ $slot }}

    {{-- Footer mínimo --}}
    <p class="mt-8 text-xs text-gray-400 text-center">
        © {{ date('Y') }} AlvGluten · Celíacos No Millonarios 🌾
    </p>
</div>

@livewireScripts
</body>
</html>