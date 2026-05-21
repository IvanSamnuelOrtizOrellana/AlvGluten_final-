<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-xl p-8">

        <div class="text-center mb-6">
            <span class="text-5xl">🔑</span>
            <h1 class="text-2xl font-extrabold text-gray-800 mt-3">Nueva contraseña</h1>
            <p class="text-gray-500 text-sm mt-2">Elige una contraseña segura para tu cuenta</p>
        </div>

        <form wire:submit="resetPassword" class="space-y-5">

            <div>
                <x-input-label for="email" value="Correo electrónico" class="font-semibold text-gray-700"/>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">✉️</span>
                    <x-text-input wire:model="email" id="email" type="email" name="email"
                                  class="block w-full pl-10 rounded-xl border-gray-200 bg-gray-50"
                                  readonly/>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1"/>
            </div>

            <div>
                <x-input-label for="password" value="Nueva contraseña" class="font-semibold text-gray-700"/>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">🔒</span>
                    <x-text-input wire:model="password" id="password" type="password" name="password"
                                  class="block w-full pl-10 rounded-xl border-gray-200 focus:border-lime-400 focus:ring-lime-400"
                                  placeholder="Mínimo 8 caracteres" required autocomplete="new-password"/>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1"/>
            </div>

            <div>
                <x-input-label for="password_confirmation" value="Confirmar contraseña" class="font-semibold text-gray-700"/>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">🔐</span>
                    <x-text-input wire:model="password_confirmation" id="password_confirmation"
                                  type="password" name="password_confirmation"
                                  class="block w-full pl-10 rounded-xl border-gray-200 focus:border-lime-400 focus:ring-lime-400"
                                  placeholder="Repite tu nueva contraseña" required autocomplete="new-password"/>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1"/>
            </div>

            <button type="submit"
                    class="w-full bg-lime-600 hover:bg-lime-700 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-md active:scale-95">
                <span wire:loading.remove>Guardar nueva contraseña 🔐</span>
                <span wire:loading>Guardando...</span>
            </button>
        </form>
    </div>
</div>
