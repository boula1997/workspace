<?php
namespace App\CategoryConfigs;

/**
 * Audit logs module in the app: one readable line per change.
 * Example: "11-10-2026 14:05 · Boula N · Fee #12 updated: amount 1500 → 1200"
 */
class AuditLogCategoryConfig extends BaseCategoryConfig
{
    public static function extra($item): string
    {
        $head = implode(' · ', array_filter([
            optional($item->created_at)->format('d-m-Y H:i'),
            $item->admin_name ?: 'System',
            "{$item->model} #{$item->model_id} {$item->event}",
        ]));

        $values = $item->event === 'deleted' ? $item->old_values : $item->new_values;
        $parts = [];
        foreach ($values ?? [] as $field => $value) {
            if (in_array($field, ['id', 'created_at', 'updated_at'], true)) {
                continue;
            }
            $parts[] = $item->event === 'updated'
                ? $field . ' ' . static::show($item->old_values[$field] ?? null) . ' → ' . static::show($value)
                : $field . ' ' . static::show($value);
        }

        return $parts ? $head . ': ' . implode(', ', $parts) : $head;
    }

    private static function show($value): string
    {
        if ($value === null || $value === '') {
            return '—';
        }
        return is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
