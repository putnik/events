<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function list(Request $request)
    {
        $start = new Carbon($request->input('start'));
        $end = new Carbon($request->input('end'));

        $dir = __DIR__ . '/../../../../../data';
		$files = scandir($dir);
		$events = [];
		foreach ($files as $file) {
			if (!preg_match('/\.json$/', $file)) {
				continue;
			}
			$content = file_get_contents($dir . '/' . $file);
			$fileEvents = json_decode($content, true);
			if (json_last_error()) {
				continue;
			}
			foreach ($fileEvents as $event) {
				$eventStart = new Carbon($event['start']);
				$eventEnd = new Carbon($event['end']);
				if (
					($start <= $eventStart && $eventStart <= $end) ||
					($start <= $eventEnd && $eventEnd <= $end)
				) {
					$events[] = $event;
				}
			}
		}

        return json_encode($events);
    }
}
