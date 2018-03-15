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

        return $model->where('is_public', 1)->orWhere(function($q) use ($user) {
        	$q->participants()->where('id_user', $user->id)->exists();
        });
    }    
}