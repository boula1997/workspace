<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Academic extends Model
{
    protected $fillable = ['admin_id', 'title'];

    public function items()
    {
        return $this->hasMany(AcademicItem::class)->orderBy('id');
    }
}
