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


Route::post('/logout', function(Request $request){
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');
Route::get('/cart/count', function () {
    return response()->json([
        'count' => auth()->check()
            ? auth()->user()->cartProducts()->sum('product_user.quantity')
            : 0
    ]);
})->middleware('auth');


require __DIR__.'/auth.php';