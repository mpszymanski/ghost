<?php

namespace App\Transformers;

class MapEventTransformer 
{
	public static function transform($data)
	{
		return $data->map(function($event) {
            $e = [];
            $e['name'] = $event->name;
            $e['place_name'] = $event->place->name;
            $e['position'] = [];
            $e['position']['lat'] = (double)$event->place->lat;
            $e['position']['lng'] = (double)$event->place->lng;
            return $e;
        });
	}
}