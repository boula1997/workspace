<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Force HTTPS and correct URL
        URL::forceScheme('https');
        URL::forceRootUrl('https://yousab-tech.com/workspace/public');
        
        // Set asset URL
        $this->app['url']->forceRootUrl('https://yousab-tech.com/workspace/public');
    }
}