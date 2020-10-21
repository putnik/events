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

        $content = file_get_contents(__DIR__ . '../../../../../../public/events.json');
        $events = json_decode($content, true);
        $filteredEvents = [];
        foreach ($events as $event) {
			$eventStart = new Carbon($event['start']);
			$eventEnd = new Carbon($event['end']);
        	if (
        		($start <= $eventStart && $eventStart <= $end) ||
				($start <= $eventEnd && $eventEnd <= $end)
			) {
				$filteredEvents[] = $event;
			}
		}

        return json_encode($filteredEvents);
    }
}
