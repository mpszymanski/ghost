<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\InvitationRepository;

class EloquentInvitationRepository extends BaseRepository implements InvitationRepository
{
	public function model()
	{
		return \App\Invitation::class;
	}
}