<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    public $timestamps = false;

    public $fillable = ['name', 'event_id', 'lat', 'lng'];
}
