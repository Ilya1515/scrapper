<?php

namespace App\Console;

use Illuminate\Support\Facades\File;
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
        $filePath = 'storage\logs\logcount.log';
        $schedule->command("parse:site")->everyMinute()->appendOutputTo($filePath)->before(function () use ($filePath) {
            File::put($filePath, '');
        });

        $contents = File::get($filePath);

        $schedule->command("mail:send $contents")->everyMinute()->emailOutputTo(['taylor@example.com'], true);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}