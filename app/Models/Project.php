<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $guarded = [];
    public $timestamps = true;



    public function getPayedAttribute(){
      return $this->cost-rest($this);
    }
    
    public function feeses(){ return $this->hasMany(Fee::class); }
    public function tasks(){ return $this->hasMany(Task::class); }

    public function getImagesAttribute()
    {
        return is_array($this->files) && count($this->files) > 0 ? $this->files : ["default.jpg"];
    }
    public function getImageAttribute()
    {
        return  count($this->files)>0?$this->files[0]->url:["default.jpg"];
    }

}
