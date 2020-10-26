<?php

namespace App\Http\Controllers;

use App\Models\CalendarType;
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

	/** @var EventService */
	private $eventService;

	/**
	 * EventController constructor.
	 * @param Cache $cache
	 * @param EventService $eventService
	 */
	public function __construct( Cache $cache, EventService $eventService ) {
		$this->cache = $cache;
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

		$events =
			$this->eventService->loadCollection()
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

		/** @var VCalendar $vCalendar */
		$vCalendar = $this->cache->get( 'calendar:' . $typeName, function () use ( $type ) {
			$events = $this->eventService->loadCollection();
			$vCalendar = $events->toICalendar( $type );

			$vCalendar->setName( env( 'CALENDAR_NAME' ) );
			$vCalendar->setCalendarColor( env( 'CALENDAR_COLOR' ) );

			$ttl = CarbonInterval::seconds( (int)env( 'CALENDAR_TTL' ) )->cascade();
			$vCalendar->setPublishedTTL( $ttl->spec() );

			return $vCalendar;
		} );

		switch ( $format ) {
			case self::FORMAT_ICALENDAR:
				header( 'Content-Type: text/calendar; charset=utf-8' );
				header( 'Content-Disposition: attachment; filename="' . $typeName . '.ics"' );
				return $vCalendar->render();
			case self::FORMAT_JSON:
				// TODO
			case self::FORMAT_XML:
				// TODO
			default:
				throw new Exception( 'Invalid format' );
		}
	}
}
