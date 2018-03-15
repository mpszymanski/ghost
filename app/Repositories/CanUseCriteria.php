<?php

namespace App\Repositories;

interface CanUseCriteria {

    /**
     * Apply criterium in repository scope.
     */
    function applyCriteria();

    /**
     * Add criteria to list.
     * @param Criteira $criteria 
     */
    function addCriteria($criteria);

    /**
     * Remove criteria from list.
     * @param  Criteira $criteria
     */
    function removeCriteria($criteria);
}
