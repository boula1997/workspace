<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MorphFiles;

class Marketting extends Model
{
    use HasFactory,MorphFiles;

    protected $guarded = [];

    public function getImagesAttribute()
    {
        return  count($this->files)>0?$this->files:["default.jpg"];
    }
    public function getImageAttribute()
    {
        return  count($this->files)>0?$this->files[0]->url:["default.jpg"];
    }
}
