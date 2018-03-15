<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\EventRepository;

class EloquentEventRepository extends BaseRepository implements EventRepository
{
	public function model()
	{
		return \App\Event::class;
	}

	public function eventsNearby($lat, $lng, $distance)
	{
		$this->model = $this->model->join('places', 'places.event_id', '=', 'events.id')
            ->selectRaw("events.id, events.end_date, places.event_id, places.name, places.lat, places.lng, ( ACOS( COS( RADIANS( $lat ) ) 
                  * COS( RADIANS( lat ) )
                  * COS( RADIANS( lng ) - RADIANS( $lng ) )
                  + SIN( RADIANS( $lat  ) )
                  * SIN( RADIANS( lat ) )
              )
            * 6371
            ) AS distance")
            ->having('distance', '<', $distance);

        return $this;
	}
}