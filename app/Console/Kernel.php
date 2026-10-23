<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // WhatsApp digest of Boula D's open tasks (needs the server cron: * * * * * php artisan schedule:run)
        foreach (array_filter(array_map('trim', explode(',', (string) config('services.whatsapp.digest_times')))) as $time) {
            $schedule->command('tasks:whatsapp-digest')->dailyAt($time);
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
