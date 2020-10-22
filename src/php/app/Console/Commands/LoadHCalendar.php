<?php

namespace App\Console\Commands;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;
use function Mf2\fetch as mfFetch;

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

	private function parseHEvent(array $mf): ?Event
	{
		if (!isset($mf['type'][0]) || $mf['type'][0] !== 'h-event') {
			return null;
		}
		$data = $mf['properties'];
		if (!isset($data['start'][0], $data['name'][0])) {
			return null;
		}

		[$title, $url] = $this->parseHCard($data['name'][0]);
		return new Event([
			'start' => new Carbon($data['start'][0]),
			'end' => isset($data['end'][0])
				? new Carbon($data['end'][0])
				: new Carbon($data['start'][0]),
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
			mb_convert_encoding($data['properties']['name'][0], 'UTF-8', 'UTF-8'),
			mb_convert_encoding($data['properties']['url'][0] ?? '', 'UTF-8', 'UTF-8')
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
			$event = $this->parseHEvent($mf);
			if ($event !== null) {
				$events[] = $event;
			}
		}
		$filename = self::DATA_DIR . '/' . md5($url) . '.json';
		$json = json_encode($events, JSON_UNESCAPED_UNICODE);
		file_put_contents($filename, $json);
	}
}
