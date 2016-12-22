<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ConvertDocuments::class,
        Commands\CheckPendingRequestForms::class,
        Commands\SendEmails::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('documents:convert')->cron('* * * * * *');
        $schedule->command('emails:send')->cron('* * * * * *');
        $schedule->command('request_forms:check_pending')->cron('20 0 * * * *');
    }
}
