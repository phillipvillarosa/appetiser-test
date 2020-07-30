<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventDate;
use App\Http\Controllers\Controller;
use App\Utils\EventsArranger;

class EventController extends Controller
{
    public function save() 
    {
    	$this->validate(request(), [
    		'name' => 'required',
    		'from' => 'required',
    		'to' => 'required',
    	]);

    	$event = Event::updateOrCreate([
            'from' => request()->from,
            'to' => request()->to,
        ], [
            'name' => request()->name
        ]);

    	$event->addEventDates(request()->days, request()->from, request()->to);

    	return response()->json([
    		'success' => true,
    		'data' => $event->toArray()
    	]);
    }

    public function getEvents() 
    {
        // by default, the current month
        $from = now();
        $to = now();

        if (request()->has('from') && request()->has('to')) {
            $from = request()->from;
            $to = request()->to;
        }

        $event_from = date('Y-m-01', strtotime($from));
        $event_to  = date('Y-m-t', strtotime($to));

        $event_data = EventDate::whereBetween('date', [$event_from, $event_to])->get();
        $arranger = new EventsArranger($event_data, $event_from, $event_to);
        $events = $arranger->arrange();

        $data = [
            'month' => date('M', strtotime($from)),
            'year' => date('Y', strtotime($from)),
            'events' => $events
        ];

        return response()->json($data);
    }
}
