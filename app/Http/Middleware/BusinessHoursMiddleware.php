<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BusinessHoursMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
            return $next($request);

         updateStopClosingStatus();

        if(settings()->stopClosing)
        return $next($request);

        
        date_default_timezone_set('Africa/Cairo');

        $dayOfWeek = date('w'); // 0 (Sunday) to 6 (Saturday)
        $currentHour = (int) date('G'); // 24-hour format without leading zeros

        if ($dayOfWeek == 6 || $dayOfWeek == 5) {
            // Saturday and Friday: Closed all day
            return response()->view('closed');
        }


        // Sunday to Thursday: Open 11 AM to 7 PM
        if ($currentHour >= 11 && $currentHour < 19) {
            return $next($request);
        }

        return response()->view('closed');
    }
}
