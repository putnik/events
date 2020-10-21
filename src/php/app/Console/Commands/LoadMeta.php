<?php

namespace App\Console\Commands;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;

final class LoadMeta extends Command
{
	private const URL = 'https://meta.wikimedia.org/wiki/Events_calendar/events.json?action=raw';
	private const FILENAME = __DIR__ . '/../../../../../data/meta.json';

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'load:meta';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Load data from [[m:Events calendar]]';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function handle(): void
	{
		$content = file_get_contents(self::URL);
		$metaEvents = json_decode($content, true);
		$events = [];
		foreach ($metaEvents as $metaEvent) {
			$url = str_replace(
				' ',
				'_',
				$metaEvent['link']
			);
			$url = preg_replace(
				'/^:?d:/',
				'https://www.wikidata.org/wiki/',
				$url
			);
			$url = preg_replace(
				'/^:([a-z\-]+):/',
				'https://\1.wikipedia.org/wiki/',
				$url
			);
			if (strpos($url, '://') === false) {
				$url = 'https://meta.wikimedia.org/wiki' . $url;
			}
			$event = new Event([
				'start' => new Carbon($metaEvent['dtstart']),
				'end' => new Carbon($metaEvent['dtend']),
				'title' => $metaEvent['title'],
				'desc' => $metaEvent['description'],
				'url' => $url,
				'callUrl' => '',
			]);
			$events[] = $event;
		}
		$json = json_encode($events);
		file_put_contents(self::FILENAME, $json);
	}
}
