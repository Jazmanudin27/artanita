<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Sanctum\Sanctum;
class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
    ];

    public function boot(): void
    {
        $this->registerPolicies();
        Sanctum::ignoreMigrations();
    }
}
