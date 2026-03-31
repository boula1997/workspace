<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class phoneGig extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function callHistories()
    {
        return $this->hasMany(CallHistory::class);
    }
}
