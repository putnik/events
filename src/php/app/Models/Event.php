<?php

namespace App\Models;

use Carbon\Carbon;
use Eluceo\iCal\Component\Event as ICalendarEvent;
use Eluceo\iCal\Property\Event\RecurrenceRule;
use Jenssegers\Model\Model;

final class Event extends Model {
	protected $fillable = [
		'start',
		'end',
		'name',
		'description',
		'url',
		'call_url',
		'location',
		'categories',
		'attendees',
		'rrule',
	];

	protected $casts = [
		'start' => 'datetime',
		'end' => 'datetime',
		'name' => 'string',
		'description' => 'string',
		'url' => 'string',
		'call_url' => 'string',
		'location' => 'string',
		'rrule' => 'array',
	];

	/**
	 * @return Carbon
	 * @throws \Exception
	 */
	public function getStart(): Carbon {
		return new Carbon( $this->getAttribute( 'start' ) );
	}

	/**
	 * @return Carbon
	 * @throws \Exception
	 */
	public function getEnd(): Carbon {
		return new Carbon( $this->getAttribute( 'end' ) );
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->getAttribute( 'name' );
	}

	/**
	 * @return string
	 */
	public function getDescription(): string {
		return $this->getAttribute( 'description' );
	}

	/**
	 * @return string
	 */
	public function getUrl(): string {
		return $this->getAttribute( 'url' );
	}

	/**
	 * @return string
	 */
	public function getCallUrl(): string {
		return $this->getAttribute( 'call_url' );
	}

	/**
	 * @return string
	 */
	public function getLocation(): string {
		return $this->getAttribute( 'location' );
	}

	/**
	 * @return string[]
	 */
	public function getCategories(): array {
		return $this->getAttribute( 'categories' );
	}

	/**
	 * @param array $categories
	 */
	public function addCategories( array $categories ): void {
		$newCategories = array_unique( array_merge(
			$this->getAttribute( 'categories' ),
			$categories
		) );
		$this->setAttribute( 'categories', array_values( $newCategories ) );
	}

	/**
	 * @return string[]
	 */
	public function getAttendees(): array {
		return $this->getAttribute( 'attendees' );
	}

	/**
	 * @return RecurrenceRule|null
	 * @throws \Exception
	 */
	public function getRecurrenceRule(): ?RecurrenceRule {
		$ruleData = $this->getAttribute( 'rrule' );
		if ( !$ruleData ) {
			return null;
		}

		$rrule = new RecurrenceRule();
		if ( !empty( $ruleData['freq'] ) ) {
			$rrule->setFreq( strtoupper( $ruleData['freq'] ) );
		}
		if ( !empty( $ruleData['interval'] ) ) {
			$rrule->setInterval( (int)$ruleData['interval'] );
		}
		if ( !empty( $ruleData['until'] ) ) {
			$until = Carbon::createFromTimestamp( (int)$ruleData['until'] );
			$rrule->setUntil( $until );
		}

		return $rrule;
	}

	/**
	 * @return array
	 */
	public function toFullCalendarArray(): array {
		$eventData = $this->attributesToArray();
		$eventData['title'] = $eventData['name'];
		unset( $eventData['name'] );
		return $eventData;
	}

	/**
	 * @param CalendarType $type
	 * @return ICalendarEvent
	 * @throws \Exception
	 */
	public function toICalendarEvent( CalendarType $type ): ICalendarEvent {
		$vEvent = new ICalendarEvent();
		$vEvent->setDtStart( $this->getStart() )
			->setDtEnd( $this->getEnd() )
			->setSummary( $this->getName() )
			->setUrl( $this->getUrl() )
			->setLocation( $this->getLocation() )
			->setCategories( $this->getCategories() );

		$description = $this->getDescription();
		if ( $type->isSupportUrl() ) {
			$vEvent->setUrl( $this->getUrl() );
		} else {
			$description .= sprintf( "\n%s", $this->getUrl() );
		}
		if ( $this->getCallUrl() ) {
			$description .= sprintf( "\n%s", $this->getCallUrl() );
		}
		$description = trim( $description );
		$vEvent->setDescription( $description );

		$rrule = $this->getRecurrenceRule();
		if ( $rrule !== null ) {
			$vEvent->addRecurrenceRule( $rrule );
		}

		return $vEvent;
	}
}
