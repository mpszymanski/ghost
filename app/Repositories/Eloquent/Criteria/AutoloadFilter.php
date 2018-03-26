<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria;

/**
* Criteria select only entries owned by passed user.
*/
class AutoloadFilter implements Criteria
{
	private $query;

	function __construct($query)
	{
		$this->query = $query;
	}

    public function apply($model)
    {
        return $model->where('nick', 'like', "%{$this->query}%")->orWhere('email', 'like', "%{$this->query}%");
    }    
}