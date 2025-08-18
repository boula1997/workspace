<?php

namespace App\Models;

use App\Traits\MorphFile;
use App\Traits\MorphFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;


class Project extends Model
{
    use HasFactory,MorphFiles,MorphFile;
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
        return  count($this->files)>0?$this->files:["default.jpg"];
    }
    
    public function getImageAttribute()
    {
        return  count($this->files)>0?$this->files[0]->url:["default.jpg"];
    }
    // public function getDealAttribute()
    // {
    //     return  $this->deal;
    // }

    public function getStatusAttribute()
    {
        if(!$this->tasks()->exists() && rest($this)>0)
        return 2;
        else if($this->tasks()->exists() && rest($this)>0)
        return 1;
        else 
        return 0;
    }
}
