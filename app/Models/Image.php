<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends \App\Models\BaseModel
{
    use HasFactory;
    protected $table = 'images';
    protected $guarded = [];
    public $timestamps = true;
    
    public function getPathAttribute($val)
    {
        return  asset($val);
    }

    public function Gallery(){
        return $this->belongsTo(Gallery::class,'gallery_id');
    }
}
