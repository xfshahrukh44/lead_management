<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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

        // Admin
        Gate::define('isAdmin', function($user)
        {
            return $user->type === 'Admin';
        });
        
        // Agent
        Gate::define('isAgent', function($user)
        {
            return $user->type === 'Agent';
        });

        // Manager
        Gate::define('isManager', function($user)
        {
            return $user->type === 'Manager';
        });

        // User
        Gate::define('isUser', function($user)
        {
            return $user->type === 'User';
        });
    }
}
