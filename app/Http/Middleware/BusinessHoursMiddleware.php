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
               // Set timezone if needed (default is UTC)
        date_default_timezone_set('Africa/Cairo'); // or your correct timezone

        $currentHour = (int) date('G'); // 24-hour format without leading zeros

        if ($currentHour >= 11 && $currentHour < 19) {
            return $next($request); // allow access
        }

        // Outside business hours
        return response()->view('closed'); // show a view named 'closed.blade.php'
    }
}
