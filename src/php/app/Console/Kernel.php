<?php

namespace App\Console;

use App\Console\Commands\LoadHCalendar;
use App\Console\Commands\LoadMeta;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    	LoadHCalendar::class,
		LoadMeta::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
		$schedule->command(LoadMeta::class)->daily();
		$schedule->command(LoadHCalendar::class, [
			'https://en.wikipedia.org/wiki/Template:Meetup',
		])->daily();
    }
}
