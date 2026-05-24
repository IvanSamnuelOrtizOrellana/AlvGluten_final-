<div class="max-w-lg mx-auto px-4 py-20 text-center">
    <div class="text-8xl mb-6">🎉</div>
    <h1 class="text-3xl font-extrabold text-gray-900 mb-3">
        ¡Pedido confirmado!
    </h1>
    <p class="text-gray-500 mb-2">
        Tu pedido
        <span class="font-bold text-lime-600">
            #{{ session('orden_confirmada') }}
        </span>
        fue procesado exitosamente.
    </p>
    <p class="text-sm text-gray-400 mb-8">
        Revisa tu correo — te enviamos el resumen completo. 
    </p>

    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <a href="{{ route('home') }}"
           class="bg-lime-600 hover:bg-lime-700 text-white font-bold py-3 px-8 rounded-xl shadow transition-all">
            Seguir comprando
        </a>
        <a href="{{ route('mis-pedidos') }}"
           class="border-2 border-gray-200 hover:border-lime-400 text-gray-600 font-semibold py-3 px-8 rounded-xl transition-all">
            Ver mis pedidos
        </a>
    </div>
</div>