<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Models\Product;


// Rutas para iniciar sesión con Google
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::get('/dashboard', function () {
    return view('/dashboard');
})->middleware('auth')->name('dashboard'); //1. Así protegemnos la ruta dashboard con el Middleware 'auth'
Route::get('/logout', function(){  //2. Para destruir la sesion de forma segura,
    auth()->logout();
    // Esto limpia la memoria de la sesion
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');


Route::get('/', function () {
    $products = Product::with('category')->get();


    return view('welcome', compact('products'));
});
