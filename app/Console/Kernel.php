<?php

namespace App\Console;

use App\Console\Commands\BulkDeleteIdpUsersCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        BulkDeleteIdpUsersCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        Log::debug("Schedule running");
        Log::info("Schedule running info");
        Log::critical("Schedule critical");
        Log::channel("saga")->info("saga log");
    }
}
