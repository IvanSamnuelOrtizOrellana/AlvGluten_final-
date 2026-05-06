<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvGluten - Tienda Oficial</title>

    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased flex flex-col min-h-screen">

<!-- Navbar de navegación -->
<nav class="bg-orange-600 p-4 shadow-md">
    <<div>
        @auth
            <a href="{{ route('dashboard') }}" class="hover:underline mr-4">Mi Panel ({{ auth()->user()->name }})</a>

            
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-700 px-4 py-2 rounded font-bold">Salir</button>
            </form>
        @else

            <a href="{{ route('login') }}" class="text-white hover:underline mr-4 font-bold">Iniciar Sesión</a>
            <a href="{{ route('register') }}" class="bg-white text-orange-600 hover:bg-gray-200 px-4 py-2 rounded font-bold transition">Registrarse</a>
        @endauth
    </div>
</nav>


<main class="max-w-7xl mx-auto p-6 flex-grow">
    {{ $slot }}
</main>

<!-- Footer rápido para que se vea pro -->
<footer class="bg-gray-800 text-white text-center p-4 mt-auto">
    <p>&copy; {{ date('Y') }} AlvGluten. Todos los derechos reservados.</p>
</footer>

@livewireScripts
</body>
</html>