<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessHoursMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        date_default_timezone_set('Africa/Cairo');

        $dayOfWeek = date('w'); // 0 (Sunday) to 6 (Saturday)
        $currentHour = (int) date('G'); // 24-hour format without leading zeros

        // Saturday (6): Closed all day
        if ($dayOfWeek == 6) {
            return response()->view('closed');
        }

        // Friday (5): Open 6 AM to 2 PM
        if ($dayOfWeek == 5) {
            if ($currentHour >= 6 && $currentHour < 14) {
                return $next($request);
            } else {
                return response()->view('closed');
            }
        }

        // Other days: Open 11 AM to 7 PM
        if ($currentHour >= 11 && $currentHour < 19) {
            return $next($request);
        }

        return response()->view('closed');
    }
}
