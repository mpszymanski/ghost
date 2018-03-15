<?php

namespace App\Repositories;

interface Repository {

    /**
     * Get all entries.
     * @param  array  $columns 
     * @return Illuminate\Support\Collection     
     */
    function all($columns = ['*']);

    /**
     * Get all entries by primary key (id).
     * @param  int        $id      
     * @param  array      $columns 
     * @return Illuminate\Database\Eloquent\Model          
     */
    function find($id, $columns = ['*']);

    /**
     * Find all entries passed throw where
     * @param  array  $where   
     * @param  array  $columns 
     * @return Illuminate\Support\Collection   
     */
    function findWhere(array $where, $columns = ['*']);
    
    /**
     * Create new entry.
     * @param  array $attributes 
     * @return Illuminate\Database\Eloquent\Model           
     */
    function create(array $attributes);

    /**
     * Create many new entries at once.
     * @param  array $attributes 
     * @return Illuminate\Database\Eloquent\Model           
     */
    function createMany(array $entries);

    /**
     * Update entry if exist in database.
     * @param  int           $id     
     * @param  array $attributes 
     * @return Illuminate\Support\Collection   
     */
    function update($id, array $attributes);

    /**
     * Delete entry if exist in database or set it as deleted if soft delete is enabled.
     * @param  int $id 
     * @return boolean
     */
    function delete($id);

    /**
     * Delete entry forever if exist in database.
     * @param  int $id 
     * @return [type]     
     */
    function hardDelete($id);

    /**
     * Get models related with model.
     * @param  string/array $relationships
     * @return this
     */
    function with($relationships);

    /**
     * Get number of models related with model.
     * @param  string/array $relationships
     * @return this
     */
    function withCount($relationships);

    /**
     * Join another tables.
     * @param  string/array $join
     * @return this
     */
    function joinWith($join);

    /**
     * Order results.
     * @param string/array $column 
     * @param string $order  
     * @return this
     */
    function OrderBy($column, $order = 'asc');

    /**
     * Set query limit and execute.
     * @param  int $number 
     * @return this
     */
    function take($number, $columns = ['*']);
}