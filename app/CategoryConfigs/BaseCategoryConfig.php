<?php
namespace App\CategoryConfigs;

use Illuminate\Database\Eloquent\Builder;

class BaseCategoryConfig
{
    /*
    |--------------------------------------------------------------------------
    | Dynamic Search (Supports Relations)
    |--------------------------------------------------------------------------
    */
    public static function applySearch(Builder $query, array $values, array $searchKeys)
    {
        $query->where(function ($q) use ($values, $searchKeys) {

            foreach ($values as $i => $val) {

                if (!isset($searchKeys[$i])) break;

                $key = $searchKeys[$i];

                static::applyField($q, $key, $val);
            }
        });
    }

    protected static function applyField($query, $key, $val)
    {
        // 🔥 Relation support: project.title
        if (str_contains($key, '.')) {

            [$relation, $column] = explode('.', $key);

            $query->whereHas($relation, function ($q) use ($column, $val) {
                $q->where($column, 'LIKE', "%{$val}%");
            });

        } else {

            $query->where($key, 'LIKE', "%{$val}%");
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Default Transform
    |--------------------------------------------------------------------------
    */
    public static function transform($item, $titleField)
    {
        return [
            'id'    => $item->id,
            'title' => $item->{$titleField} ?? $item->id,
            'extra' => optional($item->created_at)?->format('d-m-Y H:i'),
        ];
    }
}