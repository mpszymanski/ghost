<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria;
use Carbon\Carbon;

/**
* Criteria select only entries owned by passed user.
*/
class NotHappenedYet implements Criteria
{
    public function apply($model)
    {
        return $model->whereDate('end_date', '>', Carbon::tomorrow());
    }    
}