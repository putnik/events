<?php

namespace App\Services;

use App\Models\Source;
use App\Models\SourceCollection;

class IniService {
	/**
	 * @return SourceCollection
	 */
	public function loadSources(): SourceCollection {
		$iniFile = __DIR__ . '/../../../../' . env( 'SOURCES_FILE' );
		$sections = parse_ini_file( $iniFile, true );

		$sources = new SourceCollection();

		foreach ( $sections as $section ) {
			foreach ( $section['url'] as $url ) {
				$source = new Source( [
					'parser' => $section['parser'],
					'url' => $url,
					'categories' => $section['categories'] ?? [],
				] );
				$sources->add( $source );
			}
		}

		return $sources;
	}
}
