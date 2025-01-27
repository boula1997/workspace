<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Project extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $guarded = [];
    public $timestamps = true;
    
    public function fees(){ return $this->hasMany(Fee::class); }
    public function tasks(){ return $this->hasMany(Task::class); }

}
