<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['admin_id', 'name', 'description', 'is_current'];

    protected $casts = ['is_current' => 'boolean'];
}
