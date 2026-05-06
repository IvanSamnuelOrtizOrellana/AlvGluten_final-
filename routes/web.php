<?php

use App\Livewire\Catalog;
use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Tu Catálogo Perrón como página principal
Route::get('/', Catalog::class)->name('home');

// El Dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Tus rutas de Google Auth
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// LA RUTA QUE TE FALTA (El destructor de sesiones blindado)
Route::post('/logout', function(Request $request){
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Cargar las rutas que instaló Breeze (Login, Registro, etc.)
require __DIR__.'/auth.php';