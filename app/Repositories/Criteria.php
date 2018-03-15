<?php

namespace App\Repositories;

interface Criteria {

    /**
     * Apply criterium in repository scope.
     * @param  Illuminate\Database\Eloquent\Model $model
     * @return Illuminate\Database\Eloquent\Model
     */
    function apply($model);

}
