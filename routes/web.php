<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Models\Product;


// Rutas para iniciar sesión con Google
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::get('/dashboard', function () {
    return "¡Login exitoso! Bienvenido al sistema de AlvGluten, " . auth()->user()->name;
});
Route::get('/', function () {
    // 1. Le pedimos al Modelo que traiga TODOS los productos, e incluya su categoría
    $products = Product::with('category')->get();

    // 2. Retornamos la vista 'welcome' y le "inyectamos" la variable $products usando compact()
    return view('welcome', compact('products'));
});
