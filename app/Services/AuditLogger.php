<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Accountant;
use App\Models\AuditLog;
use App\Models\Fee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class AuditLogger
{
    // Finance tables that are logged when written directly by table name
    // (the app's generic storeUpdate/deleteItem endpoints skip model events).
    public const AUDITED_TABLES = [
        'fees' => Fee::class,
        'accountants' => Accountant::class,
        'accounts' => Account::class,
    ];

    private const IGNORED_FIELDS = ['updated_at'];

    public static function record(Model $model, string $event, ?array $old, ?array $new): void
    {
        self::write(class_basename($model), $model->getKey(), $event, $old, $new);
    }

    public static function isAuditedTable(string $table): bool
    {
        return isset(self::AUDITED_TABLES[$table]);
    }

    /**
     * Logs a change made by table name, from the raw row before and after the write
     * (null before = created, null after = deleted). An update that changed nothing is not logged.
     */
    public static function recordRow(string $table, $id, ?array $before, ?array $after): void
    {
        $class = self::AUDITED_TABLES[$table] ?? null;
        if (!$class || ($before === null && $after === null)) {
            return;
        }
        $hidden = (new $class)->getHidden();

        if ($before === null) {
            self::write(class_basename($class), $id, 'created', null, Arr::except($after ?? [], $hidden));
            return;
        }
        if ($after === null) {
            self::write(class_basename($class), $id, 'deleted', Arr::except($before, $hidden), null);
            return;
        }

        $changed = array_keys(array_filter(
            Arr::except($after, array_merge($hidden, self::IGNORED_FIELDS)),
            fn ($value, $field) => !array_key_exists($field, $before) || $before[$field] !== $value,
            ARRAY_FILTER_USE_BOTH
        ));
        if (!$changed) {
            return;
        }
        self::write(class_basename($class), $id, 'updated', Arr::only($before, $changed), Arr::only($after, $changed));
    }

    private static function write(string $model, $id, string $event, ?array $old, ?array $new): void
    {
        [$admin, $channel] = self::actor();
        $request = app()->runningInConsole() ? null : request();

        AuditLog::create([
            'model' => $model,
            'model_id' => $id,
            'event' => $event,
            'old_values' => $old,
            'new_values' => $new,
            'admin_id' => $admin?->id,
            'admin_name' => $admin?->name,
            'admin_email' => $admin?->email,
            'channel' => $channel,
            'ip_address' => $request?->ip(),
            'user_agent' => $request ? mb_substr((string) $request->userAgent(), 0, 512) : null,
            'url' => $request ? mb_substr($request->fullUrl(), 0, 500) : null,
        ]);
    }

    // Who made the change: an admin in the dashboard (session), an admin through the API (JWT),
    // or the system (console command, queue job, or a request without a signed-in admin).
    private static function actor(): array
    {
        if (auth('admin')->check()) {
            return [auth('admin')->user(), 'dashboard'];
        }
        if (!app()->runningInConsole() && request()->bearerToken() && auth('admin-api')->check()) {
            return [auth('admin-api')->user(), 'api'];
        }
        return [null, app()->runningInConsole() ? 'console' : 'system'];
    }
}
