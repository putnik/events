<?php

namespace App\Models;

use Jenssegers\Model\Model;

final class Source extends Model {
	protected $fillable = [
		'parser',
		'url',
		'categories',
	];

	protected $casts = [
		'parser' => 'string',
		'url' => 'string',
	];

	/**
	 * @return string
	 */
	public function getParser(): string {
		return $this->getAttribute( 'parser' );
	}

	/**
	 * @return string
	 */
	public function getUrl(): string {
		return $this->getAttribute( 'url' );
	}

	/**
	 * @return string[]
	 */
	public function getCategories(): array {
		return $this->getAttribute( 'categories' );
	}
}
