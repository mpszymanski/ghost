<?php

namespace App\Repositories\Eloquent;

use App\Repositories\CanUseCriteria;
use App\Repositories\Criteria;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;

abstract class BaseRepository implements Repository, CanUseCriteria
{
    /*
    |--------------------------------------------------------------------------
    | Base repository
    |--------------------------------------------------------------------------
    |
    | This is base repository with function shared by all models in application.
    | IMPORTANT NOTE:
    |     Do not use DB facade and do not run query on model!
    |     Any operation with database should be done by repository!
    |
    */

    protected $model;

    protected $criterias = [];

    abstract function model();

    function __construct()
    {
        $this->makeModel();
    }

    protected function makeModel()
    {
        $model = app()->make($this->model());

        if (! $model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function all($columns = ['*']) 
    {
        $this->applyCriteria();

        $results = $this->model->get($columns);

        // Reset model
        $this->makeModel();

        return $results;
    }

    public function find($id, $columns = ['*']) 
    {
        $this->applyCriteria();
        
        $results = $this->model->select($columns)->find($id);

        // Reset model
        $this->makeModel();

        return $results;
    }

    public function findWhere(array $where, $columns = ['*']) 
    {
        $this->applyCriteria();

        $this->model = $this->model->select($columns);

        if(count($where) == 3) {
            list($col, $opr, $val) = $where;
            $results =  $this->model->where($col, $opr, $val)->get();
        } else {
            $results =  $this->model->where($where)->get();
        }

        // Reset model
        $this->makeModel();

        return $results;
    }

    public function create(array $params) 
    {
        $result = $this->model->create($params);

        $this->makeModel();

        return $result;
    }

    public function createMany(array $entries) 
    {
        $result = [];

        foreach($entries as $entry)
            $result[] = $this->model->create($entry);
        
        $this->makeModel();

        return $result;
    }

    public function update($id, array $params) 
    {
        $entry = $this->model->find($id);
        $entry = $entry->fill($params);

        $entry->save();

        // Reset model
        $this->makeModel();

        return $entry;
    }

    public function updateWhere(array $where, array $params) 
    {
        $this->applyCriteria();

        $entries = $this->model->where($where)->get();

        // Make updates
        foreach ($entries as $key => $entry) {
            $entry->fill($params);
            $entry->save();
        }

        // Reset model
        $this->makeModel();

        return $entries;
    }

    public function updateOrCreate(array $where, array $params)
    {
        $this->applyCriteria();

        $entry = $this->model->updateOrCreate($where, $params);
        
        return $entry;
    }

    public function delete($id) 
    {
        $this->applyCriteria();

        $result = $this->model->destroy($id);

        // Reset model
        $this->makeModel();

        return $result;
    }

    public function hardDelete($id) 
    {
        //
    }

    public function with($relationships) 
    {
        $this->model = $this->model->with($relationships);

        return $this;
    }

    public function withCount($relationships) 
    {
        $this->model = $this->model->withCount($relationships);

        return $this;
    }

    public function joinWith($join) 
    {
        //
    }

    public function orderBy($column, $order = 'asc') 
    {
        $this->model->orderBy($column, $order);

        return $this;
    }

    public function take($number, $columns = ['*'])
    {
        $this->applyCriteria();

        $results = $this->model->take($number)->get($columns);

        // Reset model
        $this->makeModel();

        return $results;
    }

    public function applyCriteria()
    {
        $model = $this->model;

        foreach ($this->criterias as $criteria) {
            $model = $criteria->apply($model);
        }

        $this->model = $model;
    }

    public function addCriteria($criteria)
    {
        if( $criteria instanceof Criteria )
            $this->criterias[] = $criteria;
        else
            throw new \Exception("Criterium must be an instance of App\\Repositories\\Criteria.");
    }

    public function removeCriteria($criteria)
    {
        //
    }

    public function exists($where)
    {
        $this->applyCriteria();

        $result = $this->model->where($where)->exists();

        // Reset model
        $this->makeModel();

        return $result;
    }
}
