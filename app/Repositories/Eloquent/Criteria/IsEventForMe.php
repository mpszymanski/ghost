<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria;

/**
* Criteria select only entries owned by passed user.
*/
class IsEventForMe implements Criteria
{
    public function apply($model)
    {
    	$user = \Auth::user();
    	
    	if(! $user)
        	return $model->whereIsPublic(1);

        return $model->where(function($query) use ($user) {
            $query->whereIsPublic(1)->orWhere('user_id', $user->id)->orWhereHas('invitations', function($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        });
    }    
}