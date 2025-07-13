<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // ✅ Pindahkan scheduler ke sini
        $schedule->command('leaderboard:update')
                 ->dailyAt('23:00'); // atau ->everyMinute() untuk testing
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        // routes/console.php hanya untuk definisi command
        require base_path('routes/console.php');
    }
}
