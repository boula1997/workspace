<?php

namespace App\Models;

use App\Traits\MorphFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Team extends Model implements TranslatableContract
{
    use HasFactory, Translatable, MorphFile;
    protected $table = 'teams';
    protected $guarded = [];
    public $translatedAttributes = ['title', 'subtitle', 'description'];
    public $timestamps = true;

    public function getImageAttribute()
    {
        return  $this->file?asset($this->file->url): settings()->logo;
    }
}
