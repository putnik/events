<?php

namespace App\Console\Commands;

use App\Services\EventLoadService;
use Illuminate\Console\Command;

final class LoadHCalendar extends Command {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'load:hcalendar {url}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Load data from page with hCalendar microformat';

	/** @var EventLoadService */
	private $eventLoadService;

	/**
	 * Create a new command instance.
	 *
	 * @param EventLoadService $eventLoadService
	 */
	public function __construct( EventLoadService $eventLoadService ) {
		parent::__construct();

		$this->eventLoadService = $eventLoadService;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function handle(): void {
		$url = $this->argument( 'url' );
		$this->eventLoadService->loadHCalendar( $url );
	}
}
