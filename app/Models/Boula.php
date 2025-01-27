<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boula extends Model
{
    use HasFactory;
    protected $fillable = [
        'client', 'fees', 'cost','payed','debit','deadline','tasks','status','codeLinks','lastTransaction','deal'
    ];
}
