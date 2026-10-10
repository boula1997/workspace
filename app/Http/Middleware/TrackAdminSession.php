<?php

namespace App\Http\Middleware;

use App\Services\AdminSessionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Records that a signed-in admin's token was used (for the "active sessions" list). Activity
 * tracking is bookkeeping only: if it fails, the request still succeeds and the error is logged.
 */
class TrackAdminSession
{
    public function __construct(private AdminSessionService $sessions)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->bearerToken() && auth('admin-api')->check()) {
            try {
                $jti = auth('admin-api')->payload()->get('jti');
                if ($jti) {
                    $this->sessions->touch(auth('admin-api')->user(), $jti, $request);
                }
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return $response;
    }
}
