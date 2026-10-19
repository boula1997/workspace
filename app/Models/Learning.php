<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    public const STATUSES = ['todo', 'learning', 'done'];

    protected $fillable = ['admin_id', 'title', 'notes', 'status'];
}
