<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AlvGluten</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px; background-color: #f3f4f6;">

<div style="background-color: white; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h2>🛡️ Panel de Control Exclusivo</h2>
    <hr>
    <p>¡Qué onda, <strong>{{ auth()->user()->name }}</strong>!</p>
    <p>Haz iniciado sesión de manera exitosa, bienvenido <strong>{{auth()->user()->name}}</strong>. A la mejor página Gluten-free </p>

    <br>
    <!-- Botón para cerrar sesión -->
    <a href="{{ route('logout') }}" style="background-color: #ef4444; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">
        Cerrar Sesión
    </a>
</div>

</body>
</html>