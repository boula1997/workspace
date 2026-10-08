<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadyClientResbonseMessage extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $casts = [
        'is_comment'  => 'boolean',
        'is_personal' => 'boolean',
    ];

    // Older app builds still read `type` ('freelance' | 'job' | 'comment'). Keep sending it, derived
    // from gig_type + is_comment, until every installed app uses gig_type / is_comment.
    protected $appends = ['type'];

    public function getTypeAttribute(): ?string
    {
        return $this->is_comment ? 'comment' : $this->gig_type;
    }
}
