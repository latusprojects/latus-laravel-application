<?php

namespace Latus\Laravel\Providers;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('service', function ($app, array $config) {

            return $app->make(\Latus\Permissions\Services\UserProvider::class);
        });
    }
}
