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
	 * @param CarbonInterval|null $ttl
	 * @return VCalendar
	 * @throws \Exception
	 */
	public function makeICalendar(
		EventCollection $events,
		?CalendarType $type = null,
		?CarbonInterval $ttl = null
	): VCalendar {
		if ( $type === null ) {
			$type = new CalendarType( CalendarType::OTHER );
		}
		$vCalendar = $events->toICalendar( $type );

		$vCalendar->setName( env( 'CALENDAR_NAME' ) );
		$vCalendar->setCalendarColor( env( 'CALENDAR_COLOR' ) );

		if ( $ttl !== null ) {
			$vCalendar->setPublishedTTL( $ttl->spec() );
		}

		return $vCalendar;
	}
}
