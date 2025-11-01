<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Account extends \App\Models\BaseModel
{
    use HasFactory;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'fees', 'cost','payed','debit','deadline','tasks','status','codeLinks','lastTransaction','deal','appearance'
    ];
}