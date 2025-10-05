<?php

namespace App\Http\Middleware;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return redirect(route('admin.login-view'));
        }else{


        updateStopClosingStatus();

        if(settings()->stopClosing)
        return $next($request);

        
        date_default_timezone_set('Africa/Cairo');

        $dayOfWeek = date('w'); // 0 (Sunday) to 6 (Saturday)
        $currentHour = (int) date('G'); // 24-hour format without leading zeros

        //Holly Mass Timings

        if(($dayOfWeek == 0 || $dayOfWeek == 5) && $currentHour >= 5 && $currentHour < 15){
            return $next($request);

        }


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
    }
}
