<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class saleGig extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Admin who created the gig
    public function author()
    {
        return $this->belongsTo(Admin::class, 'author_id');
    }
}
