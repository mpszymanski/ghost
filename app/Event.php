<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function place()
    {
    	return $this->hasOne('App\Place');
    }

    public function owner()
    {
    	return $this->belongsTo('App\User');
    }

    public function participants()
    {
    	return $this->hasMany('App\Participant');
    }
}
