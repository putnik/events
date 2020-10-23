<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventCollection;
use Carbon\Carbon;
use function Mf2\fetch as mfFetch;

class EventLoadService {
	public const META_URL = 'https://meta.wikimedia.org/wiki/Events_calendar/events.json?action=raw';
	public const DATA_DIR = __DIR__ . '/../../../../data';

	public const H_CARD = 'h-card';
	public const H_EVENT = 'h-event';

	/**
	 * @param string $url
	 * @return string
	 */
	private function prepareUrl( string $url ): string {
		$url = (string)str_replace( ' ', '_', $url );
		$url = preg_replace( '/^:?d:/', 'https://www.wikidata.org/wiki/', $url );
		$url = preg_replace( '/^:([a-z\-]+):/', 'https://\1.wikipedia.org/wiki/', $url );
		if ( strpos( $url, '://' ) === false ) {
			$url = 'https://meta.wikimedia.org/wiki/' . $url;
		}
		return $url;
	}

	/**
	 * @param string $url
	 * @param EventCollection $events
	 */
	private function storeData( string $url, EventCollection $events ): void {
		$json = json_encode( $events->toArray(), JSON_UNESCAPED_UNICODE );
		$filename = self::DATA_DIR . '/' . md5( $url ) . '.json';
		file_put_contents( $filename, $json );
	}

	public function clearDir(): void {
		$files = scandir( self::DATA_DIR );
		foreach ( $files as $file ) {
			if ( !preg_match( '/\.json$/', $file ) ) {
				continue;
			}
			unlink( self::DATA_DIR . '/' . $file );
		}
	}

	/**
	 * @param array $mf
	 * @return Event|null
	 * @throws \Exception
	 */
	private function parseHEvent( array $mf ): ?Event {
		if ( !isset( $mf['type'][0] ) || $mf['type'][0] !== self::H_EVENT ) {
			return null;
		}
		$data = $mf['properties'];
		if ( !isset( $data['start'][0] ) || !isset( $data['name'][0] ) ) {
			return null;
		}

		[ $name, $url ] = $this->parseHCard( $data['name'][0] );
		if ( $name === null ) {
			return null;
		}

		return new Event( [
			'start' => new Carbon( $data['start'][0] ),
			'end' => isset( $data['end'][0] ) ? new Carbon( $data['end'][0] )
				: new Carbon( $data['start'][0] ),
			'name' => $name,
			'description' => $data['summary'][0] ?? $data['description'][0] ?? '',
			'location' => $data['location'][0] ?? '',
			'categories' => $data['category'] ?? [],
			'attendees' => [],
			'url' => $url,
			'call_url' => '',
		] );
	}

	/**
	 * @param array|string $data
	 * @return array
	 */
	private function parseHCard( $data ): array {
		if ( is_string( $data ) ) {
			return [
				$data,
				''
			];
		}
		if ( !isset( $data['type'][0] ) || $data['type'][0] !== self::H_CARD ) {
			return null;
		}
		return [
			mb_convert_encoding( $data['properties']['name'][0], 'UTF-8', 'UTF-8' ),
			mb_convert_encoding( $data['properties']['url'][0] ?? '', 'UTF-8', 'UTF-8' )
		];
	}

	/**
	 * @param string $url
	 * @throws \Exception
	 */
	public function loadHCalendar( string $url ): void {
		$data = mfFetch( $url );

		$events = new EventCollection();
		foreach ( $data['items'] as $mf ) {
			$event = $this->parseHEvent( $mf );
			if ( $event !== null ) {
				$events->add( $event );
			}
		}

		$this->storeData( $url, $events );
	}

	/**
	 * @param string $url
	 * @throws \Exception
	 */
	public function loadMeta( string $url ): void {
		$content = file_get_contents( $url );
		$metaEvents = json_decode( $content, true );
		$events = new EventCollection();
		foreach ( $metaEvents as $metaEvent ) {
			$event = new Event( [
				'start' => new Carbon( $metaEvent['dtstart'] ),
				'end' => new Carbon( $metaEvent['dtend'] ),
				'name' => $metaEvent['title'],
				'description' => $metaEvent['description'],
				'url' => $this->prepareUrl( $metaEvent['link'] ?? '' ),
				'call_url' => '',
				'location' => implode( ', ', $metaEvent['location'] ),
				'categories' => $metaEvent['tags'] ?? [],
				'attendees' => [],
			] );
			$events->add( $event );
		}
		$this->storeData( $url, $events );
	}
}
