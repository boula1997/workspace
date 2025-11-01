<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends \App\Models\BaseModel
{
    use HasFactory;
    protected $table = 'newsletters';
    protected $guarded = [];
    public $timestamps = true;
    
}
