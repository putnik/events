<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventCollection;

class EventService {
	/**
	 * @return EventCollection
	 */
	public function loadCollection(): EventCollection {
		$dir = EventLoadService::DATA_DIR;
		$files = scandir( $dir );
		$events = new EventCollection();
		foreach ( $files as $file ) {
			if ( !preg_match( '/\.json$/', $file ) ) {
				continue;
			}
			$content = file_get_contents( $dir . '/' . $file );
			$fileEvents = json_decode( $content, true, 512, JSON_THROW_ON_ERROR );
			if ( json_last_error() ) {
				continue;
			}
			foreach ( $fileEvents as $eventData ) {
				$event = new Event( $eventData );
				$events->add( $event );
			}
		}
		return $events;
	}
}
