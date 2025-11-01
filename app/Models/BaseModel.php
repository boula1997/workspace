<?php

// app/Models/BaseModel.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ActiveScope;

class BaseModel extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }
}
