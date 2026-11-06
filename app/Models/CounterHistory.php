<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounterHistory extends Model
{
    // admin_id is set by the controller from the signed-in admin, never from the request
    protected $fillable = ['admin_id', 'op_uuid', 'item_uuid', 'field', 'old_value', 'new_value', 'changed_at'];

    protected $casts = [
        'changed_at' => 'datetime',
    ];
}
