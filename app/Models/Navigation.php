<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    protected $guarded=[];


    //     public function getLinkAttribute($value)
    // {
    //     return  $value.'?user='.$this->user.'&password='.$this->password;
    // }
}

