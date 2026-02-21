<?php
namespace App\CategoryConfigs;

class TaskCategoryConfig extends BaseCategoryConfig
{
    protected static function applyField($query, $key, $val)
    {
        if ($key === 'status') {

            $status = strtolower($val) === 'live' ? 0 : 1;

            $query->where('status', $status);
            return;
        }

        parent::applyField($query, $key, $val);
    }

    public static function transform($item, $titleField)
    {
        return [
            'id' => $item->id,
            'title' => $item->title,
            'extra' =>
                optional($item->project)->title . ", " .
                ($item->status == 0 ? "live" : "finished") . ", " .
                optional($item->created_at)?->format('d-m-Y H:i'),
        ];
    }
}