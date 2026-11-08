<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyDebt extends Model
{
    // admin_id is set by the controller from the signed-in admin, never from the request
    protected $fillable = ['admin_id', 'name', 'amount'];

    protected $casts = [
        'amount' => 'float',
    ];
}
