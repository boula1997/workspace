<?php

namespace App\Models;

use App\Traits\MorphFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;



class Category extends Model implements TranslatableContract
{
    use HasFactory, Translatable, MorphFile;
    protected $table = 'categories';
    public $translatedAttributes = ['title', 'subtitle', 'description'];
    protected $guarded = [];
    public $timestamps = true;

    public function getImageAttribute(){
        return  $this->file? asset($this->file->url): settings()->logo;
   }
    
}
