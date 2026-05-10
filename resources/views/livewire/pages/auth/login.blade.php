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

<div class="w-full max-w-sm mx-auto bg-white p-8 border border-gray-200 rounded-2xl shadow-lg">
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">

        <div class="text-center mb-6">
            <h5 class="text-2xl font-extrabold text-gray-900 tracking-tight">Iniciar Sesión</h5>
            <p class="text-sm text-gray-500 mt-1">Bienvenido de nuevo a AlvGluten</p>
        </div>

        <div class="mb-4">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Tu correo</label>
            <input wire:model="form.email" type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full px-4 py-2.5 shadow-sm" placeholder="ejemplo@correo.com" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-sm text-red-600" />
        </div>

        <div class="mb-4">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Tu contraseña</label>
            <input wire:model="form.password" type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full px-4 py-2.5 shadow-sm" placeholder="•••••••••" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-sm text-red-600" />
        </div>

        <div class="flex items-center justify-between my-6">
            <div class="flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-2 focus:ring-orange-500 text-orange-600">
                <label for="remember" class="ms-2 text-sm font-medium text-gray-900">Recordarme</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate class="text-sm font-bold text-orange-600 hover:underline">¿Olvidaste tu contraseña?</a>
            @endif
        </div>

        <button type="submit" class="text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 font-bold rounded-lg text-sm px-4 py-2.5 focus:outline-none w-full mb-4 transition-colors shadow-md">
            Entrar a mi cuenta
        </button>

        <div class="flex items-center justify-between mb-4">
            <span class="border-b border-gray-200 w-1/5 lg:w-1/4"></span>
            <span class="text-xs text-center text-gray-400 uppercase font-bold">O entra con</span>
            <span class="border-b border-gray-200 w-1/5 lg:w-1/4"></span>
        </div>

        <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-2 bg-white border border-gray-300 text-gray-700 px-4 py-2.5 rounded-lg hover:bg-gray-50 transition shadow-sm font-bold mb-4">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="h-5 w-5" alt="Google">
            Google
        </a>

        <div class="text-sm font-medium text-center text-gray-600 mt-4">
            ¿No tienes cuenta? <a href="{{ route('register') }}" wire:navigate class="text-orange-600 hover:underline font-bold">Crear cuenta</a>
        </div>
    </form>
</div>