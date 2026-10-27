<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicItem extends Model
{
    protected $fillable = ['academic_id', 'question', 'answer'];

    public function academic()
    {
        return $this->belongsTo(Academic::class);
    }
}
