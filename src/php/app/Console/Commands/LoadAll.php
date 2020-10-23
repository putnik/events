<?php

namespace App\Console\Commands;

use App\Services\EventLoadService;
use Illuminate\Console\Command;

final class LoadAll extends Command {
	private const HCALENDAR_SOURCES = [
		'https://en.wikipedia.org/wiki/Wikipedia:Meetup/Calendar',
		'https://ru.wikipedia.org/wiki/Википедия:Вики-встречи/Архив',
	];

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'load:all';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Load data from all available sources';

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
		$this->eventLoadService->clearDir();
		$this->eventLoadService->loadMeta( EventLoadService::META_URL );
		foreach ( self::HCALENDAR_SOURCES as $url ) {
			$this->eventLoadService->loadHCalendar( $url );
		}
	}
}
