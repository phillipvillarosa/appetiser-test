<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDate extends Model
{
    protected $fillable = ['date'];

    protected $with = 'event';

    public function event()
    {
    	return $this->belongsTo('App\Models\Event');
    }
}
