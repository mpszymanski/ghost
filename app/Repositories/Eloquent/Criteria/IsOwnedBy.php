<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria;

/**
* Criteria select only entries owned by passed user.
*/
class IsOwnedBy implements Criteria
{
	private $owner_id;

	function __construct(\App\User $owner)
	{
		$this->owner_id = $owner->id;
	}

    public function apply($model)
    {
        return $model->where('user_id', $this->owner_id);
    }    
}