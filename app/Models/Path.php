<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Accessor for the `path` attribute
    public function getPathAttribute($value)
    {
        // Replace backslashes with forward slashes
        return str_replace('\\', '/', $value);
    }
}
