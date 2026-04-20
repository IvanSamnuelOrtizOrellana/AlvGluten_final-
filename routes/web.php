<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;

Route::get('/', function () {
    return view('welcome');

});
// Rutas para iniciar sesión con Google
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::get('/dashboard', function () {
    return "¡Login exitoso! Bienvenido al sistema de AlvGluten, " . auth()->user()->name;
});
