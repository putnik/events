<?php

namespace App\Console\Commands;

use App\Services\EventLoadService;
use App\Services\IniService;
use Illuminate\Console\Command;

final class LoadAll extends Command {
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

	/** @var IniService */
	private $iniService;

	/**
	 * Create a new command instance.
	 *
	 * @param EventLoadService $eventLoadService
	 * @param IniService $iniService
	 */
	public function __construct( EventLoadService $eventLoadService, IniService $iniService ) {
		parent::__construct();

		$this->eventLoadService = $eventLoadService;
		$this->iniService = $iniService;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function handle(): void {
		$this->info( 'Data dir: ' . realpath( EventLoadService::DATA_DIR ) );
		$this->eventLoadService->clearDir();
		$sources = $this->iniService->loadSources();
		foreach ( $sources->all() as $source ) {
			$this->info( 'Load ' . $source->getParser() . ': ' . $source->getUrl() );
			$this->eventLoadService->load( $source );
		}
	}
}
