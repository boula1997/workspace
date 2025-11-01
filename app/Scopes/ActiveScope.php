<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Apply isActive = 1 filter automatically
        // if (schemaHasColumn($model->getTable(), 'isActive')) {
            $builder->where($model->getTable() . '.isActive', 1);
        // }
    }
}

/**
 * Helper: checks if a table has a given column
 */
if (!function_exists('schemaHasColumn')) {
    function schemaHasColumn($table, $column)
    {
        try {
            return \Schema::hasColumn($table, $column);
        } catch (\Exception $e) {
            return false;
        }
    }
}
