<?php

namespace App\Models;

use App\Traits\MorphFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
class Faq extends Model implements TranslatableContract
{
    use HasFactory, Translatable,MorphFile;
    protected $table = 'faqs';
    protected $guarded = [];
    public $translatedAttributes = ['title', 'description'];
    public $timestamps = true;

    public function getImageAttribute(){
         return  $this->file?asset($this->file->url): settings()->logo;
    }

}
 