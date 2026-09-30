<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class phoneGig extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function callHistories()
    {
        return $this->hasMany(CallHistory::class);
    }
}