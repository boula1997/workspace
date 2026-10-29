<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    // admin_id is set by the controller from the signed-in admin, never from the request
    protected $fillable = ['admin_id', 'action', 'duration_sec'];

    protected $casts = [
        'duration_sec' => 'integer',
    ];
}
