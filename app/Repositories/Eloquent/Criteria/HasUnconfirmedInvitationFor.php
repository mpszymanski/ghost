<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria;

/**
* Criteria select only entries owned by passed user.
*/
class HasUnconfirmedInvitationFor implements Criteria
{
    private $user_id;

	function __construct(\App\User $user)
	{
		$this->user_id = $user->id;
	}

    public function apply($model)
    {
        $user_id = $this->user_id;
        return $model->whereHas('invitations', function($q) use ($user_id) {
        	$q->where('user_id', $user_id)->where('is_confirmed', 0);
        });
    }
}