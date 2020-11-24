<?php

namespace App\Console\Commands;

use App\Models\CalendarType;
use App\Services\CalendarService;
use App\Services\EventService;
use Illuminate\Console\Command;

final class CalendarExport extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'calendar:export {type} {format}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Export calendar to given type and format';

	/** @var CalendarService */
	private $calendarService;

	/** @var EventService */
	private $eventService;

	/**
	 * Create a new command instance.
	 *
	 * @param CalendarService $calendarService
	 * @param EventService $eventService
	 */
	public function __construct(
		CalendarService $calendarService, EventService $eventService
	) {
		parent::__construct();

		$this->calendarService = $calendarService;
		$this->eventService = $eventService;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function handle(): void {
		$typeName = $this->argument( 'type' );
		$type = new CalendarType( $typeName );
		$format = $this->argument( 'format' );
		$filename = $typeName . '.' . $format;
		$this->info( 'File: ' . $filename );

		$events = $this->eventService->loadCollection();
		$vCalendar = $this->calendarService->makeICalendar( $events, $type );
		file_put_contents( $filename, $vCalendar->render() );
	}
}
