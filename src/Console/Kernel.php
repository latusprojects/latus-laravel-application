<?php

namespace Latus\Laravel\Console;


class Kernel extends \Illuminate\Foundation\Console\Kernel
{
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        //require base_path('routes/console.php');
    }
}