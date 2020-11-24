<?php

namespace App\Services;

use App\Models\CalendarType;
use App\Models\EventCollection;
use Carbon\CarbonInterval;
use Eluceo\iCal\Component\Calendar as VCalendar;

final class CalendarService {
	/**
	 * @param EventCollection $events
	 * @param CalendarType|null $type
	 * @return VCalendar
	 * @throws \Exception
	 */
	public function makeICalendar(
		EventCollection $events,
		?CalendarType $type = null
	): VCalendar {
		if ( $type === null ) {
			$type = new CalendarType( CalendarType::OTHER );
		}
		$vCalendar = $events->toICalendar( $type );

		$vCalendar->setName( env( 'CALENDAR_NAME' ) );
		$vCalendar->setCalendarColor( env( 'CALENDAR_COLOR' ) );

		$ttl = CarbonInterval::seconds( (int)env( 'CALENDAR_TTL' ) )->cascade();
		$vCalendar->setPublishedTTL( $ttl->spec() );

		return $vCalendar;
	}
}
