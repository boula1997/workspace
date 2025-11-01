<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ActiveScope;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \Log::info('AppServiceProvider booted ✅'); // add this temporarily

        Model::creating(function ($model) {
            if (!isset($model->isActive)) {
                $model->isActive = 1;
            }
        });

        Model::addGlobalScope(new ActiveScope);
    }
}
