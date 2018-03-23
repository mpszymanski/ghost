<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\UserRepository;

class EloquentUserRepository extends BaseRepository implements UserRepository
{
	public function model()
	{
		return \App\User::class;
	}
}