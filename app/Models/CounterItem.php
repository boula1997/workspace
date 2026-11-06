<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounterItem extends Model
{
    // admin_id is set by the controller from the signed-in admin, never from the request
    protected $fillable = ['admin_id', 'uuid', 'category_uuid', 'title', 'count', 'note', 'is_hidden'];

    protected $casts = [
        'count' => 'integer',
        'is_hidden' => 'boolean',
    ];
}
