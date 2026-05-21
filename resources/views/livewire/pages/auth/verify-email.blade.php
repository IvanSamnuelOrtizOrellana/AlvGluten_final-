<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

        <span class="text-6xl">📧</span>
        <h1 class="text-2xl font-extrabold text-gray-800 mt-4">Verifica tu correo</h1>
        <p class="text-gray-500 text-sm mt-3 leading-relaxed">
            Te enviamos un link de verificación a tu correo. Ábrelo para activar tu cuenta
            y empezar a comprar sin gluten. 🌾
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mt-4 bg-lime-50 border border-lime-200 text-lime-700 text-sm rounded-xl p-3">
                ✅ ¡Listo! Te reenviamos el correo de verificación.
            </div>
        @endif

        <div class="mt-6 flex flex-col gap-3">
            <form wire:submit="sendVerification">
                <button type="submit"
                        class="w-full bg-lime-600 hover:bg-lime-700 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-md active:scale-95">
                    <span wire:loading.remove>Reenviar correo de verificación</span>
                    <span wire:loading>Enviando...</span>
                </button>
            </form>

            <form wire:submit="logout">
                <button type="submit"
                        class="w-full border-2 border-gray-200 hover:border-red-300 hover:bg-red-50 text-gray-600 hover:text-red-600 font-semibold py-2.5 px-4 rounded-xl transition-all text-sm">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</div>
