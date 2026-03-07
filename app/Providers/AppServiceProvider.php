<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ActiveScope;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    { Carbon::setTimezone('Africa/Cairo');

    }
}
