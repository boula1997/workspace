<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditLogger
{
    public static function record(Model $model, string $event, ?array $old, ?array $new): void
    {
        [$admin, $channel] = self::actor();
        $request = app()->runningInConsole() ? null : request();

        AuditLog::create([
            'model' => class_basename($model),
            'model_id' => $model->getKey(),
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
