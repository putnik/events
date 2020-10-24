<?php

namespace App\Models;

use Eluceo\iCal\Component\Calendar as VCalendar;

/**
 * @method Event[] all
 */
class EventCollection extends AbstractCollection {
	public const MODEL = Event::class;

	/**
	 * @return array
	 */
	public function toFullCalendarArray(): array {
		$out = [];
		foreach ( $this->all() as $event ) {
			/** @var Event $event */
			$out[] = $event->toFullCalendarArray();
		}
		return $out;
	}

	/**
	 * @return VCalendar
	 * @throws \Exception
	 */
	public function toICalendar(): VCalendar {
		$vCalendar = new VCalendar( 'events.toolforge.org' );
		foreach ( $this->all() as $event ) {
			$vEvent = $event->toICalendarEvent();
			$vCalendar->addComponent( $vEvent );
		}
		return $vCalendar;
	}
}
