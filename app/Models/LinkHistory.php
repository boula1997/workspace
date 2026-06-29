<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkHistory extends Model
{
    protected $fillable = ['post_gig_id'];

    public function postGig()
    {
        return $this->belongsTo(PostGig::class);
    }
}