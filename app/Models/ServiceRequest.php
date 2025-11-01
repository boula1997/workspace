<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends \App\Models\BaseModel
{
    use HasFactory;
    protected $table = 'serviceRequests';
    protected $guarded = [];
    public $timestamps = true;
    
}
