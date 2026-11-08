<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyDebtSkip extends Model
{
    // money_debt_id is set by the controller after checking the debt belongs to the signed-in admin
    protected $fillable = ['money_debt_id', 'month'];
}
