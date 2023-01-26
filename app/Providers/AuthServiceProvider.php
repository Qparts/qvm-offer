<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Guard\JWTCustomGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->app['auth']->extend(
            'jwt-auth',
            function ($app, $name, array $config) {
                $guard = new JWTCustomGuard(
                    $app['tymon.jwt'],
                    $app['request']
                );
                $app->refresh('request', $guard, 'setRequest');
                return $guard;
            }
        );
    }
}
