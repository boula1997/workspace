<?php

namespace App\Models;

use App\Traits\MorphFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Partner extends Model implements TranslatableContract
{
    use HasFactory, Translatable, MorphFile;
    protected $table = 'partners';
    protected $guarded = [];
    public $translatedAttributes = ['title'];
    public $timestamps = true;

    public function getImageAttribute()
    {
        return  $this->file?asset($this->file->url): settings()->logo;
    }
}
