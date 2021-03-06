<?php

namespace App\Http\Controllers;

use App\Models\CalendarType;
use App\Services\CalendarService;
use App\Services\EventService;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Eluceo\iCal\Component\Calendar as VCalendar;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

final class EventController extends Controller {
	private const FORMAT_ICALENDAR = 'ics';
	private const FORMAT_JSON = 'json';
	private const FORMAT_XML = 'xml';

	/** @var Cache */
	private $cache;

	/** @var CalendarService */
	private $calendarService;

	/** @var EventService */
	private $eventService;

	/**
	 * EventController constructor.
	 * @param Cache $cache
	 * @param CalendarService $calendarService
	 * @param EventService $eventService
	 */
	public function __construct(
		Cache $cache,
		CalendarService $calendarService,
		EventService $eventService
	) {
		$this->cache = $cache;
		$this->calendarService = $calendarService;
		$this->eventService = $eventService;
	}

	/**
	 * @param Request $request
	 * @return string
	 * @throws \Exception
	 */
	public function fullCalendar( Request $request ): string {
		$start = new Carbon( $request->input( 'start' ) );
		$end = new Carbon( $request->input( 'end' ) );

		$events = $this->eventService->loadCollection()
			->filterAfter( $start )
			->filterBefore( $end )
			->toFullCalendarArray();

		return json_encode( $events, JSON_THROW_ON_ERROR );
	}

	/**
	 * @param string $typeName
	 * @param string $format
	 * @return string
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function iCalendar( string $typeName, $format = self::FORMAT_ICALENDAR ): string {
		$type = new CalendarType( $typeName );
		$ttl = CarbonInterval::seconds( (int)env( 'CALENDAR_TTL' ) )->cascade();

		/** @var VCalendar $vCalendar */
		$vCalendar = $this->cache->remember(
			'calendar:' . $typeName,
			$ttl->seconds,
			function () use ( $type, $ttl ) {
				$events = $this->eventService->loadCollection();
				return $this->calendarService->makeICalendar( $events, $type, $ttl );
			}
		);

		switch ( $format ) {
			case self::FORMAT_ICALENDAR:
				header( 'Content-Type: text/calendar; charset=utf-8' );
				header( 'Content-Disposition: attachment; filename="' . $typeName . '.ics"' );
				return $vCalendar->render();
			case self::FORMAT_JSON:
				// TODO
				header( 'Content-Type: application/json; charset=utf-8' );
				header( 'Content-Disposition: attachment; filename="' . $typeName . '.json"' );
				break;
			case self::FORMAT_XML:
				// TODO
				header( 'Content-Type: text/xml; charset=utf-8' );
				header( 'Content-Disposition: attachment; filename="' . $typeName . '.xml"' );
				break;
			default:
				throw new Exception( 'Invalid format' );
		}
	}
}
