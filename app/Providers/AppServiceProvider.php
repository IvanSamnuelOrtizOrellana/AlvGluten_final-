<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Lo que hace gate::define('nombre'recibe el nombre del usuario autenticado)
        // retorna true o flase para livewire y blade lo lean con @can
        Gate::define('es-admin', fn(User $user) => $user->isAdmin());
    }
}
