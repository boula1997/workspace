<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;

use App\Scopes\DateFilterScope;
class Fee extends Model
{
    use HasFactory;
    protected $table = 'fees';
    protected $guarded = [];
    public $translatedAttributes = ['title'];
    public $timestamps = true;






    public function project(){ return $this->belongsTo(Project::class,'project_id'); }
    
}
