<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvGluten V2 - Login</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f3f4f6; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; }
        .google-btn { background-color: #db4437; color: white; text-decoration: none; padding: 12px 24px; border-radius: 5px; font-weight: bold; display: inline-block; margin-top: 20px; transition: 0.3s; }
        .google-btn:hover { background-color: #c23321; }
    </style>
</head>
<body>
<div class="login-box">
    <h1>Bienvenido a AlvGluten V2 🌾</h1>
    <p>El servidor Toshiba está listo para recibirte.</p>

    <a href="{{ url('/auth/google/redirect') }}" class="google-btn">
        Iniciar sesión con Google
    </a>
</div>
</body>
</html>
