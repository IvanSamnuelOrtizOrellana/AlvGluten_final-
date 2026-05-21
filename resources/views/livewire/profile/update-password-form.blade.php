<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <div class="mb-5">
        <h2 class="text-lg font-extrabold text-gray-800 flex items-center gap-2">
             Cambiar Contraseña
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Usa una contraseña larga y aleatoria para mantener tu cuenta segura.
        </p>
    </div>

    <form wire:submit="updatePassword" class="space-y-4">

        <div>
            <x-input-label for="update_password_current_password" value="Contraseña actual" class="font-semibold text-gray-700"/>
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none"></span>
                <x-text-input wire:model="current_password"
                              id="update_password_current_password" name="current_password"
                              type="password"
                              class="block w-full pl-10 rounded-xl border-gray-200 focus:border-lime-400 focus:ring-lime-400"
                              placeholder="Tu contraseña actual"
                              autocomplete="current-password"/>
            </div>
            <x-input-error :messages="$errors->get('current_password')" class="mt-1"/>
        </div>

        <div>
            <x-input-label for="update_password_password" value="Nueva contraseña" class="font-semibold text-gray-700"/>
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">🔒</span>
                <x-text-input wire:model="password"
                              id="update_password_password" name="password"
                              type="password"
                              class="block w-full pl-10 rounded-xl border-gray-200 focus:border-lime-400 focus:ring-lime-400"
                              placeholder="Mínimo 8 caracteres"
                              autocomplete="new-password"/>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1"/>
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="Confirmar nueva contraseña" class="font-semibold text-gray-700"/>
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none"></span>
                <x-text-input wire:model="password_confirmation"
                              id="update_password_password_confirmation" name="password_confirmation"
                              type="password"
                              class="block w-full pl-10 rounded-xl border-gray-200 focus:border-lime-400 focus:ring-lime-400"
                              placeholder="Repite tu nueva contraseña"
                              autocomplete="new-password"/>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1"/>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                    class="bg-lime-600 hover:bg-lime-700 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-md active:scale-95">
                <span wire:loading.remove wire:target="updatePassword">Guardar cambios</span>
                <span wire:loading wire:target="updatePassword">Guardando...</span>
            </button>

            <x-action-message class="text-sm text-lime-600 font-medium" on="password-updated">
                 ¡Contraseña actualizada!
            </x-action-message>
        </div>
    </form>
</section>
