<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Scopes\DateFilterScope;

class Followup extends Model
{
    use HasFactory;
    protected $table = 'followups';
    protected $guarded = [];
    public $translatedAttributes = ['title'];
    public $timestamps = true;

    protected static function booted()
    {
        static::addGlobalScope(new DateFilterScope);
    }

    // public function project(){
    //     return $this->belongsTo(Project::class,'project_id');
    // }
    public function employee(){
        return $this->belongsTo(Admin::class,'employee_id');
    }
    
}
