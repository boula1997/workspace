<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boula extends \App\Models\BaseModel
{
    use HasFactory;
    protected $fillable = [
        'title', 'fees', 'cost','payed','debit','deadline','tasks','status','codeLinks','lastTransaction','deal'
    ];
}
