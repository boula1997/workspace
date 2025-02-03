<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class DateFilterScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $startDate = settings()->start_date;
        $endDate = settings()->end_date;

        if ($startDate && $endDate) {
            $builder->whereBetween('date', [$startDate, $endDate]);
        }
    }
}
