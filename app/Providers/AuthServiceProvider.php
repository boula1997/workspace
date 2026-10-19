<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
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

        // The owner (Super Admin role) passes every permission check - sidebar @can, controller
        // permission middleware and policies - whatever permissions their other roles hold.
        Gate::before(function ($user) {
            return $user instanceof \App\Models\Admin && $user->isSuperAdmin() ? true : null;
        });
    }
}
