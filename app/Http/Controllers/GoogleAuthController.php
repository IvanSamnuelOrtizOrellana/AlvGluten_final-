<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    // Método 1: Manda al usuario a Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Método 2: Recibe los datos de Google y hace el Login
    public function callback()
    {
        // 1. Obtenemos los datos encriptados que nos manda Google
        $googleUser = Socialite::driver('google')->stateless()->user();

        // 2. Buscamos si ya existe el correo. Si no, lo crea (UpdateOrCreate)
        $user = User::updateOrCreate([
            'email' => $googleUser->email,
        ], [
            'name' => $googleUser->name,
            // Le ponemos una contraseña aleatoria larguísima porque
            // este usuario siempre entrará con Google, no con contraseña.
            'password' => bcrypt(Str::random(24)),
        ]);

        // 3. Le decimos a Laravel que inicie la sesión de este usuario
        Auth::login($user);

        // 4. Lo mandamos a su panel de control
        return redirect('/dashboard');
    }
}
