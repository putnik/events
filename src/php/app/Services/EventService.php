<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventCollection;
use Carbon\Carbon;

class EventService {
	/**
	 * @param Carbon $start
	 * @param Carbon|null $end
	 * @return EventCollection
	 * @throws \Exception
	 */
	public function getCollectionByDates( Carbon $start, ?Carbon $end = null ): EventCollection {
		$dir = EventLoadService::DATA_DIR;
		$files = scandir( $dir );
		$events = [];
		foreach ( $files as $file ) {
			if ( !preg_match( '/\.json$/', $file ) ) {
				continue;
			}
			$content = file_get_contents( $dir . '/' . $file );
			$fileEvents = json_decode( $content, true );
			if ( json_last_error() ) {
				continue;
			}
			foreach ( $fileEvents as $eventData ) {
				$event = new Event( $eventData );
				$eventStart = new Carbon( $event['start'] );
				$eventEnd = new Carbon( $event['end'] );
				if ( ( $start <= $eventStart && ( $eventStart <= $end || $end === null ) ) ||
					( $start <= $eventEnd && ( $eventEnd <= $end || $end === null ) ) ) {
					$events[] = $event;
				}
			}
		}

		return new EventCollection( $events );
	}
}
