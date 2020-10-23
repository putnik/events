<?php

namespace App\Console\Commands;

use App\Services\EventLoadService;
use Illuminate\Console\Command;

final class LoadMeta extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'load:meta';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Load data from [[meta:Events calendar]]';

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
		$this->eventLoadService->loadMeta( EventLoadService::META_URL );
	}
}
