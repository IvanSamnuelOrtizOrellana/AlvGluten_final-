<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-xl p-8">

        <div class="text-center mb-6">

            <h1 class="text-2xl font-extrabold text-gray-800 mt-3">¿Olvidaste tu contraseña?</h1>
            <p class="text-gray-500 text-sm mt-2">
                Sin problema. Ingresa tu correo y te mandamos un link para recuperarla.
            </p>
        </div>

        <x-auth-session-status class="mb-4 text-center text-sm text-lime-700 bg-lime-50 border border-lime-200 rounded-xl p-3" :status="session('status')" />

        <form wire:submit="sendPasswordResetLink" class="space-y-5">
            <div>
                <x-input-label for="email" value="Correo electrónico" class="font-semibold text-gray-700"/>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none"></span>
                    <x-text-input wire:model="email" id="email" type="email" name="email"
                                  class="block w-full pl-10 rounded-xl border-gray-200 focus:border-lime-400 focus:ring-lime-400"
                                  placeholder="tu@correo.com" required autofocus/>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1"/>
            </div>

            <button type="submit"
                    class="w-full bg-lime-600 hover:bg-lime-700 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-md active:scale-95">
                <span wire:loading.remove>Enviar link de recuperación </span>
                <span wire:loading>Enviando...</span>
            </button>
        </form>
    </div>

    <p class="text-center text-sm text-gray-500 mt-5">
        <a href="{{ route('login') }}" wire:navigate class="text-lime-600 font-bold hover:underline">← Volver al inicio de sesión</a>
    </p>
</div>
