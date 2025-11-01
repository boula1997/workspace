<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends \App\Models\BaseModel
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get the parent imageable model (user or post).
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrlAttribute($val)
    { 
        return file_exists($val) ? asset($val) : settings()->logo;
    }
}
