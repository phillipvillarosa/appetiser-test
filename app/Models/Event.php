<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Event extends Model
{
    protected $fillable = ['name', 'from', 'to'];

    public function addEventDates($days, $from, $to)
    {
    	$date_range =  new \DatePeriod(
		     new \DateTime($from),
		     new \DateInterval('P1D'),
		     new \DateTime($to)
		);

		$days_enabled = Arr::where($days, function($bool, $day) {
		    return $bool;
		});
		$days_enabled = array_keys($days_enabled);

		$days_disabled = Arr::where($days, function($bool, $day) {
		    return !$bool;
		});
		$days_disabled = array_keys($days_disabled);

		foreach ($date_range as $key => $value) {
		    if (in_array(strtolower($value->format('D')), $days_enabled)) {
		    	$this->eventDates()->create([
		    		'date' => $value->format('Y-m-d')
		    	]);
		    }
		    if (in_array(strtolower($value->format('D')), $days_disabled)) {
		    	$existing_event_date = $this->eventDates->where('date', '=',  $value->format('Y-m-d'))->first();
		    	if ($existing_event_date) {
		    		$existing_event_date->first()->delete();
		    	}
		    }
		}
    	
    	return $this;
    }

    public function eventDates()
    {
    	return $this->hasMany('App\Models\EventDate');
    }
}
