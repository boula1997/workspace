<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends \App\Models\BaseModel
{
    use HasFactory;

    protected $guarded=[];


public function category(){ return $this->belongsTo(Category::class,'category_id'); }
public function getPasswordAttribute(){
    return $this->confidential;
}
}


