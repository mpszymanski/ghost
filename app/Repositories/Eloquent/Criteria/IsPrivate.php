<?php

namespace App\Repositories\Criteria;

use App\Repositories\Criteria;

/**
* Criteria select only entries owned by passed user.
*/
class IsPrivate implements Criteria
{
    public function apply($model)
    {
        return $model->whereIsPublic(0);
    }    
}