<?php

namespace App\Models;

use App\Traits\MorphFile;
use App\Traits\MorphFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class Gallery extends \App\Models\BaseModel implements TranslatableContract
{
    use HasFactory, Translatable,MorphFiles,MorphFile;
    protected $table = 'galleries';
    protected $guarded = [];
    public $translatedAttributes = ['title', 'description'];
    public $timestamps = true;

    public function getImagesAttribute()
    {
        return  count($this->files)>0?$this->files:["default.jpg"];
    }
    public function getImageAttribute()
    {
        return  count($this->files)>0?$this->files[0]->url:["default.jpg"];
    }
    
}
