<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class DateFilterScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // $startDate = settings()->start_date;
        // $endDate = settings()->end_date;

        // if ($startDate && $endDate) {
        //     $builder->where(function ($query) use ($startDate, $endDate) {
        //         $query->whereBetween('created_at', [$startDate, $endDate])
        //               ->orWhereBetween('updated_at', [$startDate, $endDate]);
        //     });
        // }
    }
}
