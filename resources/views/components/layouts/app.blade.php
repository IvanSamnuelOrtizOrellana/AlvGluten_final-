<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvGluten - Tienda Oficial</title>
    <!-- Inyectamos Tailwind CSS para diseño profesional -->
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased">

<!-- Navbar de navegación -->
<nav class="bg-orange-600 p-4 shadow-md">
    <div class="max-w-7xl mx-auto flex justify-between items-center text-white">
        <a href="/" class="text-2xl font-bold flex items-center gap-2">
            🍞 AlvGluten
        </a>
        <div>
            @auth
                <a href="{{ route('dashboard') }}" class="hover:underline mr-4">Mi Panel ({{ auth()->user()->name }})</a>
                <a href="{{ route('logout') }}" class="bg-red-500 hover:bg-red-700 px-4 py-2 rounded font-bold">Salir</a>
            @else
                <a href="/auth/google/redirect" class="bg-white text-orange-600 hover:bg-gray-200 px-4 py-2 rounded font-bold transition">Iniciar Sesión</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Contenido Dinámico (Aquí entrarán las demás vistas) -->
<main class="max-w-7xl mx-auto p-6">
    {{ $slot }}
</main>

@livewireScripts
</body>
</html>