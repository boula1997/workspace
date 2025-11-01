<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
class Video extends \App\Models\BaseModel implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $table = 'videos';
    protected $guarded = [];
    public $translatedAttributes = ['title'];
    public $timestamps = true;

    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }
    
}