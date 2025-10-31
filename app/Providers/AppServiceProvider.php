<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    Model::creating(function ($model) {
        if (!isset($model->isActive)) {
            $model->isActive = 1;
        }
    });

    Model::addGlobalScope(new ActiveScope);
    }
}
