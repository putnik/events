<?php

namespace App\Console;

use App\Console\Commands\LoadAll;
use App\Console\Commands\LoadHCalendar;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

final class Kernel extends ConsoleKernel {
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		LoadAll::class,
		LoadHCalendar::class,
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param Schedule $schedule
	 * @return void
	 */
	protected function schedule( Schedule $schedule ): void {
	}
}
