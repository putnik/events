<?php

namespace App\Models;

use Carbon\Carbon;
use Eluceo\iCal\Component\Event as ICalendarEvent;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
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
	];

	protected $casts = [
		'start' => 'datetime',
		'end' => 'datetime',
		'name' => 'string',
		'description' => 'string',
		'url' => 'string',
		'call_url' => 'string',
		'location' => 'string',
	];

	/**
	 * @return Carbon
	 */
	public function getStart(): Carbon {
		return $this->getAttribute( 'start' );
	}

	/**
	 * @return Carbon
	 */
	public function getEnd(): Carbon {
		return $this->getAttribute( 'end' );
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
	 * @return string[]
	 */
	public function getAttendees(): array {
		return $this->getAttribute( 'attendees' );
	}

	/**
	 * @return array
	 */
	public function toFullCalendarArray(): array {
		$eventData = $this->attributesToArray();
		$eventData['title'] = $eventData['name'];
		unset( $eventData['title'] );
		return $eventData;
	}

	/**
	 * @return ICalendarEvent
	 */
	public function toICalendarEvent(): ICalendarEvent {
		$vEvent = new ICalendarEvent();
		$vEvent
			->setDtStart( $this->getStart() )
			->setDtEnd( $this->getEnd() )
			->setSummary( $this->getName() )
			->setUrl( $this->getUrl() ?: $this->getCallUrl() )
			->setLocation( $this->getLocation() )
			->setCategories( $this->getCategories() );
		return $vEvent;
	}
}
