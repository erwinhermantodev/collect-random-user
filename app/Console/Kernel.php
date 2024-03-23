<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\FetchUserRecordsCommand::class,
        Commands\ProcessDailyRecordsCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Define your scheduled tasks here
        $schedule->command('fetch:user-records')->hourly();
        $schedule->command('process:daily-records')->dailyAt('23:59');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
