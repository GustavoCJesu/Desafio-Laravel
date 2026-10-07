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
        // Libera a habilidade quando o cargo tem o slug; do contrário (null) deixa
        // Gates e Policies decidirem, sem impor um "não" que as sobreponha.
        Gate::before(fn (User $user, string $ability): ?bool => $user->hasPermission($ability) ?: null);
    }
}
