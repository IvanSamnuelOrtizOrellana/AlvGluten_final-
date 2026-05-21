<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full max-w-md mx-auto bg-white p-8 border border-gray-200 rounded-2xl shadow-lg">
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">

        <div class="text-center mb-6">
            <h5 class="text-2xl font-extrabold text-gray-800 tracking-tight">Iniciar Sesión</h5>
            <p class="text-sm text-gray-500 mt-1">Bienvenido de nuevo a AlvGluten</p>
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="font-semibold text-gray-700 text-sm">Correo electrónico</label>
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">✉️</span>
                <input wire:model="form.email" type="email" id="email" class="block w-full pl-10 rounded-xl border-gray-200 text-sm focus:border-lime-500 focus:ring-lime-500 shadow-sm" placeholder="tu@correo.com" required autofocus autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-1" />
        </div>

        {{-- Contraseña --}}
        <div>
            <label for="password" class="font-semibold text-gray-700 text-sm">Contraseña</label>
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">🔒</span>
                <input wire:model="form.password" type="password" id="password" class="block w-full pl-10 rounded-xl border-gray-200 text-sm focus:border-lime-500 focus:ring-lime-500 shadow-sm" placeholder="•••••••••" required autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-1" />
        </div>

        {{-- Recordarme y Olvidé contraseña --}}
        <div class="flex items-center justify-between my-4">
            <div class="flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-2 focus:ring-lime-500 text-lime-600">
                <label for="remember" class="ms-2 text-sm font-medium text-gray-700">Recordarme</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate class="text-sm font-bold text-lime-600 hover:underline">¿Olvidaste tu contraseña?</a>
            @endif
        </div>

        {{-- Botón Entrar --}}
        <button type="submit" class="w-full bg-lime-600 hover:bg-lime-700 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-md hover:shadow-lg active:scale-95 text-sm">
            <span wire:loading.remove>Entrar a mi cuenta</span>
            <span wire:loading>Iniciando sesión...</span>
        </button>

        {{-- Divisor --}}
        <div class="relative my-5">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
            <div class="relative flex justify-center"><span class="bg-white px-3 text-sm text-gray-400">O entra con</span></div>
        </div>

        {{-- Google --}}
        <a href="{{ route('google.login') }}" class="flex items-center justify-center gap-3 w-full border-2 border-gray-200 hover:border-lime-400 hover:bg-lime-50 text-gray-700 font-semibold py-2.5 px-4 rounded-xl transition-all text-sm">
            <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
            Continuar con Google
        </a>

        <div class="text-sm font-medium text-center text-gray-600 mt-6">
            ¿No tienes cuenta? <a href="{{ route('register') }}" wire:navigate class="text-lime-600 hover:underline font-bold">Crear cuenta</a>
        </div>
    </form>
</div>