<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvGluten - Catálogo</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">

<h1>🍞 Catálogo Oficial: AlvGluten</h1>
<p>Estos son los datos reales traídos desde tu contenedor de MySQL:</p>

<!-- Aquí podrías poner tu botón de Login con Google en un futuro -->
<a href="{{ route('google.login') }}">Iniciar sesión con Google</a>

<hr>

<ul>
    @foreach($products as $product)
        <li style="margin-bottom: 10px;">
            <strong>{{ $product->name }}</strong> - ${{ $product->price }}
            <br>
            <small>Categoría: <em>{{ $product->category->name }}</em></small>
        </li>
    @endforeach
</ul>

</body>
</html>