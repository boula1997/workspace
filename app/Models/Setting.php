<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Setting extends Model implements TranslatableContract
{

    use HasFactory, Translatable;
    protected $table = 'settings';
    protected $guarded = [];
    public $translatedAttributes = ['title', 'subtitle', 'description','copyright'];
    public $timestamps = true;


    public function getLogoAttribute($val)
    {
        return file_exists($val) ? asset($val) :  settings()->logo;
    }
    public function getTabAttribute($val)
    {
        return file_exists($val) ? asset($val) :  settings()->logo;
    }
    public function getwhiteLogoAttribute($val)
    {
        return file_exists($val) ? asset($val) :  settings()->logo;
    }
}
