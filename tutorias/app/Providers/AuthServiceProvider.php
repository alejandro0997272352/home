<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        Gate::define('admin', fn ($user) => $user->role === 'admin');
        Gate::define('tutor', fn ($user) => $user->role === 'tutor');
        Gate::define('estudiante', fn ($user) => $user->role === 'estudiante');
    }
}
