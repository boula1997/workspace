<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    public function register(): void
    {
        $this->hideSensitiveRequestDetails();

        // REMOVE OR COMMENT OUT THE FILTER - This might be blocking requests
        // Telescope::filter(function (IncomingEntry $entry) {
        //     if ($this->app->environment('local')) {
        //         return true;
        //     }
        //     return false;
        // });
    }

    protected function hideSensitiveRequestDetails(): void
    {
        Telescope::hideRequestParameters(['_token', 'password']);
        Telescope::hideRequestHeaders(['cookie', 'x-csrf-token', 'x-xsrf-token']);
    }

    protected function gate(): void
    {
        Gate::define('viewTelescope', function ($user = null) {
            // Allow everyone for now (change in production)
            return true;
        });
    }
}