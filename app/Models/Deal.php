<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cost',
        'is_paid',
    ];

public function project()
{
    return $this->belongsTo(Project::class)->withoutGlobalScope('excludePersonal');
}

    public function deadlines()
    {
        return $this->morphMany(Deadline::class, 'deadlineable');
    }
}
