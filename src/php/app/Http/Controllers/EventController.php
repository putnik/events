<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller {
	/** @var EventService */
	private $eventService;

	/**
	 * EventController constructor.
	 * @param EventService $eventService
	 */
	public function __construct( EventService $eventService ) {
		$this->eventService = $eventService;
	}

	/**
	 * @param Request $request
	 * @return string
	 * @throws \Exception
	 */
	public function json( Request $request ): string {
		$start = new Carbon( $request->input( 'start' ) );
		$end = new Carbon( $request->input( 'end' ) );

		$events = $this->eventService->getCollectionByDates( $start, $end )->toFullCalendarArray();

		return json_encode( $events );
	}

	/**
	 * @return string
	 * @throws \Exception
	 */
	public function iCalendar(): string {
		$start = new Carbon( '-3 month' );

		$vCalendar = $this->eventService->getCollectionByDates( $start )->toICalendar();

		header( 'Content-Type: text/calendar; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="calendar.ics"' );
		return $vCalendar->render();
	}
}
