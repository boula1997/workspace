<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends \App\Models\BaseModel
{
    use HasFactory;
    protected $table='settings';
    protected $guarded = [];
}
