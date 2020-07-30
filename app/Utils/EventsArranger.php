<?php

namespace App\Utils;

/**
 * Events Arranger
 */
class EventsArranger
{
	protected $data;
	protected $date_range;

	function __construct($data, $from, $to)
	{
		$this->data = $data;
		$this->date_range = new \DatePeriod(
             new \DateTime($from),
             new \DateInterval('P1D'),
             new \DateTime($to)
        );

	}

	public function arrange()
	{
		$arr = [];
		foreach ($this->date_range as $value) {
			$date = $value->format('Y-m-d');
			$arr[$date] = [];

			$filtered = $this->data->where('date', '=', $date);
			
			if ($filtered) {
				$arr[$date] = $filtered->first();
			}
		}

		return $arr;
	}
}