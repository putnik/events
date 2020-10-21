<?php

namespace App\Console\Commands;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;
use function Mf2\fetch as mfFetch;
use function Sodium\add;

final class LoadHCalendar extends Command
{
	private const DATA_DIR = __DIR__ . '/../../../../../data';

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'load:hcalendar {url}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Load data from page with hCalendar microformat';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	private function parseHEvent(array $data): Event
	{
		[$title, $url] = $this->parseHCard($data['name'][0]);
		return new Event([
			'start' => new Carbon($data['start'][0]),
			'end' => isset($data['end'][0])
				? new Carbon($data['end'][0])
				: (new Carbon($data['start'][0]))->addHour(),
			'title' => $title,
			'desc' => '',
			'url' => $url,
			'callUrl' => '',
		]);
	}


	private function parseHCard($data): array
	{
		if (is_string($data)) {
			return [
				$data,
				''
			];
		}
		return [
			$data['properties']['name'][0],
			$data['properties']['url'][0]
		];
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function handle(): void
	{
		$url = $this->argument('url');
		$data = mfFetch($url);
		$events = [];
		foreach ($data['items'] as $mf) {
			if ($mf['type'][0] === 'h-event') {
				$events[] = $this->parseHEvent($mf['properties']);
			}
		}
		$filename = self::DATA_DIR . '/' . md5($url) . '.json';
		$json = json_encode($events);
		file_put_contents($filename, $json);
	}
}
