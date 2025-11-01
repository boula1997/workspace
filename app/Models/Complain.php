<?php

namespace App\Models;

use App\Traits\MorphFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
class Complain extends \App\Models\BaseModel implements TranslatableContract
{
    use HasFactory, Translatable,MorphFile;
    protected $table = 'complains';
    protected $guarded = [];
    public $translatedAttributes = ['title', 'description'];
    public $timestamps = true;


}
