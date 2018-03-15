<?php

namespace App\Repositories\Interfaces;

interface EventRepository
{
	/**
	 * Find all events nerby place.
	 * @param  double $lat 
	 * @param  double $lng
	 * @param  double $distance distance in km.
	 * @return Collection
	 */
	function eventsNearby($lat, $lng, $distance);
}