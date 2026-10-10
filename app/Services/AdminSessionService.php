<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\AdminSession;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token;

/**
 * Keeps admin_sessions in step with the JWTs handed out to an admin. Each token's `jti` claim
 * identifies its session.
 */
class AdminSessionService
{
    // How often a session's "last active" time is written while its token is being used.
    private const TOUCH_EVERY_MINUTES = 5;

    // A session used within this window is shown as "active now".
    public const ACTIVE_NOW_MINUTES = 10;

    public function jtiOf(string $token): ?string
    {
        return JWTAuth::manager()->decode(new Token($token))->get('jti');
    }

    // A new token was issued at login.
    public function start(Admin $admin, string $token, Request $request): void
    {
        $jti = $this->jtiOf($token);
        if (!$jti) {
            return;
        }

        AdminSession::updateOrCreate(['jti' => $jti], [
            'admin_id' => $admin->id,
            'device_name' => $this->deviceName($request),
            'ip_address' => $request->ip(),
            'user_agent' => mb_substr((string) $request->userAgent(), 0, 512),
            'last_active_at' => now(),
            'revoked_at' => null,
        ]);
    }

    // The same device received a new token (refresh, password change): keep its session row.
    public function rotate(Admin $admin, ?string $oldJti, string $newToken, Request $request): void
    {
        $newJti = $this->jtiOf($newToken);
        if (!$newJti) {
            return;
        }

        $session = $oldJti ? AdminSession::where('jti', $oldJti)->where('admin_id', $admin->id)->first() : null;
        if (!$session) {
            $this->start($admin, $newToken, $request);
            return;
        }

        $session->update([
            'jti' => $newJti,
            'ip_address' => $request->ip(),
            'last_active_at' => now(),
            'revoked_at' => null,
        ]);
    }

    // The token was logged out.
    public function end(?string $jti): void
    {
        if ($jti) {
            AdminSession::where('jti', $jti)->whereNull('revoked_at')->update(['revoked_at' => now()]);
        }
    }

    // A request was made with this token. Tokens issued before sessions were tracked get a row
    // the first time they are used.
    public function touch(Admin $admin, string $jti, Request $request): void
    {
        $updated = AdminSession::where('jti', $jti)
            ->whereNull('revoked_at')
            ->where(function ($query) {
                $query->whereNull('last_active_at')
                    ->orWhere('last_active_at', '<', now()->subMinutes(self::TOUCH_EVERY_MINUTES));
            })
            ->update(['last_active_at' => now(), 'ip_address' => $request->ip()]);

        if ($updated === 0 && !AdminSession::where('jti', $jti)->exists()) {
            AdminSession::create([
                'admin_id' => $admin->id,
                'jti' => $jti,
                'device_name' => $this->deviceName($request),
                'ip_address' => $request->ip(),
                'user_agent' => mb_substr((string) $request->userAgent(), 0, 512),
                'last_active_at' => now(),
            ]);
        }
    }

    // The app sends X-Device-Name (e.g. "Android 14"); otherwise make a rough label from the
    // user agent.
    private function deviceName(Request $request): string
    {
        $name = trim((string) $request->header('X-Device-Name'));
        if ($name !== '') {
            return mb_substr($name, 0, 100);
        }

        $agent = (string) $request->userAgent();
        return match (true) {
            str_contains($agent, 'okhttp') => 'Android app',
            str_contains($agent, 'CFNetwork') || str_contains($agent, 'Darwin') => 'iOS app',
            str_contains($agent, 'iPhone') || str_contains($agent, 'iPad') => 'iPhone / iPad browser',
            str_contains($agent, 'Android') => 'Android browser',
            str_contains($agent, 'Windows') => 'Windows browser',
            str_contains($agent, 'Macintosh') => 'Mac browser',
            str_contains($agent, 'Linux') => 'Linux browser',
            $agent !== '' => 'Other device',
            default => 'Unknown device',
        };
    }
}
