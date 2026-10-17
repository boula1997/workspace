<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class phoneGig extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Admin who created the gig (NULL for gigs created before authors were recorded)
    public function author()
    {
        return $this->belongsTo(Admin::class, 'author_id');
    }

    public function callHistories()
    {
        return $this->hasMany(CallHistory::class);
    }
}