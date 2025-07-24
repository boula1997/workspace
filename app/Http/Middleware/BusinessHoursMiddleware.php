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


        
// Get the latest setting that has an updated_at
$setting = Setting::whereNotNull('updated_at')->orderBy('updated_at', 'desc')->first();

if ($setting) {
    $diffInMinutes = Carbon::now()->diffInMinutes($setting->updated_at);
    $diffInSeconds = Carbon::now()->diffInSeconds($setting->updated_at);

    dd([
        'diff_minutes' => $diffInMinutes,
        'diff_seconds' => $diffInSeconds,
    ]);
} else {
    dd('No updated settings found.');
}


        if (Setting::where('updated_at', '>=', now()->subMinutes(2))->exists()) {
            Setting::query()->update([
                'stopClosing' => 0,
                'updated_at' => now()
            ]);
        }

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
