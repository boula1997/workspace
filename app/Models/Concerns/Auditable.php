<?php

namespace App\Models\Concerns;

use App\Services\AuditLogger;
use Illuminate\Support\Arr;

/**
 * Records every create / update / delete of the model in audit_logs (who, when, old -> new).
 *
 * The change and its log entry are saved in one transaction, so a change is never kept without its
 * log entry. Writes that bypass Eloquent (query-builder mass updates, raw SQL) are not seen here.
 */
trait Auditable
{
    // Columns that are not worth logging when they are the only change.
    protected array $auditIgnore = ['updated_at'];

    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            AuditLogger::record($model, 'created', null, $model->auditValues($model->getAttributes()));
        });

        static::updated(function ($model) {
            $changes = Arr::except($model->getChanges(), $model->auditIgnore);
            if (!$changes) {
                return;
            }
            $old = array_intersect_key($model->getRawOriginal(), $changes);
            AuditLogger::record($model, 'updated', $model->auditValues($old), $model->auditValues($changes));
        });

        static::deleted(function ($model) {
            AuditLogger::record($model, 'deleted', $model->auditValues($model->getRawOriginal() ?: $model->getAttributes()), null);
        });
    }

    public function save(array $options = [])
    {
        return $this->getConnection()->transaction(fn () => parent::save($options));
    }

    public function delete()
    {
        return $this->getConnection()->transaction(fn () => parent::delete());
    }

    private function auditValues(array $values): array
    {
        return Arr::except($values, $this->getHidden());
    }
}
