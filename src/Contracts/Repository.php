<?php
/**
 * @author Sahib J. Leo <sahib@sahib.io>
 * Date: 5/17/15, 2:26 AM
 */
namespace Sahib\Elegan\Contracts;

/**
 * Interface Repository
 *
 * @package Sahib\Elegan\Contracts
 */
interface Repository
{
    /**
     * Get all records.
     *
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * Find a model by its primary key.
     *
     * @param mixed $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param mixed $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*']);

    /**
     * Execute the query and get the first result.
     *
     * @param array $columns
     * @return mixed
     */
    public function first($columns = ['*']);

    /**
     * Execute the query and get the first result or throw an exception.
     *
     * @param array $columns
     * @return mixed
     */
    public function firstOrFail($columns = ['*']);

    /**
     * Find a model by its attribute.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = ['*']);

    /**
     * Find a model by its attribute or throw an exception.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $columns
     * @return mixed
     */
    public function findByOrFail($attribute, $value, $columns = ['*']);

    /**
     * Paginate the given query.
     *
     * @param null $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = null, $columns = ['*']);

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param null $perPage
     * @param array $columns
     * @return mixed
     */
    public function simplePaginate($perPage = null, $columns = ['*']);

    /**
     * Save a new model and return the instance.
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update a record in the database.
     *
     * @param int $id
     * @param array $attributes
     * @param bool $returnInstance
     * @return mixed
     */
    public function update($id, array $attributes, $returnInstance = true);

    /**
     * Destroy the models for the given IDs.
     *
     * @param array|int $ids
     * @return int
     */
    public function destroy($ids);

    /**
     * Push a criteria into the query.
     *
     * @param \Sahib\Elegan\Contracts\Criteria $criteria
     * @return mixed
     */
    public function criteria(Criteria $criteria);
}
