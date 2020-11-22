<?php

namespace App\Models;

use Carbon\Carbon;
use Eluceo\iCal\Component\Calendar as VCalendar;

/**
 * @method Event[] all
 */
final class EventCollection extends AbstractCollection {
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
	 * @param CalendarType $type
	 * @return VCalendar
	 * @throws \Exception
	 */
	public function toICalendar( CalendarType $type ): VCalendar {
		$vCalendar = new VCalendar( 'events.toolforge.org' );
		foreach ( $this->all() as $event ) {
			$vEvent = $event->toICalendarEvent( $type );
			$vCalendar->addComponent( $vEvent );
		}
		return $vCalendar;
	}

	/**
	 * @param Carbon $after
	 * @return EventCollection
	 */
	public function filterAfter( Carbon $after ): self {
		return $this->filter( function ( Event $event ) use ( $after ) {
			return $event->getStart()->isAfter( $after ) || $event->getEnd()->isAfter( $after );
		} );
	}

	/**
	 * @param Carbon $before
	 * @return EventCollection
	 */
	public function filterBefore( Carbon $before ): self {
		return $this->filter( function ( Event $event ) use ( $before ) {
			return $event->getStart()->isBefore( $before ) || $event->getEnd()->isBefore( $before );
		} );
	}

	/**
	 * @param array $categories
	 */
	public function addCategories( array $categories ): void {
		foreach ( $this->all() as $event ) {
			$event->addCategories( $categories );
		}
	}
}
