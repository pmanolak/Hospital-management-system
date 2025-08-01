<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\AlertsStockExpiry;

class Kernel extends ConsoleKernel
{
    /**
     * Register the Artisan commands.
     */
    protected $commands = [
        AlertsStockExpiry::class,  
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('reminders:appointments')->dailyAt('08:00');
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

         
        require base_path('routes/console.php');
    }
}
