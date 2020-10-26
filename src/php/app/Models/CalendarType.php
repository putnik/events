<?php

namespace App\Models;

final class CalendarType {
	public const GOOGLE = 'google';
	public const OTHER = 'other';

	public static $allowedValues = [
		self::GOOGLE,
		self::OTHER,
	];

	private $type;

	/**
	 * @param string $type
	 */
	public function __construct( string $type ) {
		if ( in_array( $type, self::$allowedValues, true ) ) {
			$this->type = $type;
		} else {
			$this->type = self::OTHER;
		}
	}

	/**
	 * @return string
	 */
	public function getType(): string {
		return $this->type;
	}

	/**
	 * @return bool
	 */
	public function isSupportUrl(): bool {
		return $this->getType() !== self::GOOGLE;
	}
}
