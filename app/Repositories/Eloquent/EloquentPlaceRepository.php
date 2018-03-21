<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\PlaceRepository;

class EloquentPlaceRepository extends BaseRepository implements PlaceRepository
{
	public function model()
	{
		return \App\Place::class;
	}
}