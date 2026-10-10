<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Account extends \App\Models\BaseModel
{
    use HasFactory;
    use \App\Models\Concerns\Auditable;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'fees', 'cost','payed','debit','deadline','tasks','status','ai_prompt','lastTransaction','deal','appearance'
    ];
}