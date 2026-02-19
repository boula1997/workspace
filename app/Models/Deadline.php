<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deadline extends \App\Models\BaseModel
{
    use HasFactory;

    protected $guarded = [];

        // Polymorphic relation
    public function deadlineable()
    {
        return $this->morphTo();
    }
}
