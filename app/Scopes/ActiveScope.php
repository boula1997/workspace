<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Apply is_active = 1 filter automatically
        // if (schemaHasColumn($model->getTable(), 'is_active')) {
            $builder->where($model->getTable() . '.is_active', 1);
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
