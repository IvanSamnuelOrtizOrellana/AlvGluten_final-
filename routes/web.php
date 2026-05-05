<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Livewire\Catalog;


Route::get('/', Catalog::class)->name('home');

// Rutas para iniciar sesión con Google
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// 1. Así protegemos la ruta dashboard con el Middleware 'auth'
Route::get('/dashboard', function () {
    return view('/dashboard');
})->middleware('auth')->name('dashboard');

// 2. Para destruir la sesion de forma segura
Route::get('/logout', function(){
    auth()->logout();
    // Esto limpia la memoria de la sesion
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');