<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicItemOption extends Model
{
    protected $fillable = ['academic_item_id', 'option_text', 'is_correct'];

    protected $casts = ['is_correct' => 'boolean'];

    protected $hidden = ['created_at', 'updated_at'];

    public function item()
    {
        return $this->belongsTo(AcademicItem::class, 'academic_item_id');
    }
}
