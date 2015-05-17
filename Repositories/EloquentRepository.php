<?php namespace Sahib\Elegan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Sahib\Elegan\Contracts\CriteriaInterface;
use Sahib\Elegan\Contracts\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{

    /**
     * @var array
     */
    protected $criteria = [];

    /**
     * Get model's name.
     *
     * @return string
     */
    abstract protected function model();

    /**
     * Get all records.
     *
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function all($columns = ['*'])
    {
        return $this->query()->all($columns);
    }

    /**
     * Find a model by its primary key.
     *
     * @param mixed $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->query()->find($id, $columns);
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param mixed $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*'])
    {
        return $this->query()->findOrFail($id, $columns);
    }

    /**
     * Execute the query and get the first result.
     *
     * @param array $columns
     * @return mixed
     */
    public function first($columns = ['*'])
    {
        return $this->query()->first($columns);
    }

    /**
     * Execute the query and get the first result or throw an exception.
     *
     * @param array $columns
     * @return mixed
     */
    public function firstOrFail($columns = ['*'])
    {
        return $this->query()->firstOrFail($columns);
    }

    /**
     * Find a model by its attribute.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = ['*'])
    {
        return $this->query()->where($attribute, $value)->first($columns);
    }

    /**
     * Find a model by its attribute or throw an exception.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $columns
     * @return mixed
     */
    public function findByOrFail($attribute, $value, $columns = ['*'])
    {
        return $this->query()->where($attribute, $value)->firstOrFail($columns);
    }

    /**
     * Paginate the given query.
     *
     * @param null $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = null, $columns = ['*'])
    {
        return $this->query()->paginate($perPage, $columns);
    }

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param null $perPage
     * @param array $columns
     * @return mixed
     */
    public function simplePaginate($perPage = null, $columns = ['*'])
    {
        return $this->query()->simplePaginate($perPage, $columns);
    }

    /**
     * Save a new model and return the instance.
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes)
    {
        $model = $this->model();

        return $model::create($attributes);
    }

    /**
     * Update a record in the database.
     *
     * @param int $id
     * @param array $attributes
     * @param bool $returnInstance
     * @return \Illuminate\Database\Eloquent\Model|int
     */
    public function update($id, array $attributes, $returnInstance = true)
    {
        $model = $this->findByOrFail($id);

        $rows = $model->update($attributes);

        if ($returnInstance) {
            return $model;
        }

        return $rows;
    }

    /**
     * Destroy the models for the given IDs.
     *
     * @param array|int $ids
     * @return int
     */
    public function destroy($ids)
    {
        $model = $this->model();

        return $model::destroy($ids);
    }

    /**
     * Push a criteria into the query.
     *
     * @param \Sahib\Elegan\Contracts\CriteriaInterface $criteria
     * @return mixed
     */
    public function criteria(CriteriaInterface $criteria)
    {
        $this->criteria[] = $criteria;
    }

    /**
     * Begin querying the model with the current criteria.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function query()
    {
        $model = $this->model();
        $query = $model::query();

        $this->applyCriteria($query);

        return $query;
    }

    /**
     * Apply criteria to the query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    protected function applyCriteria(Builder $query)
    {
        foreach ($this->criteria as $criteria) {
            $criteria->apply($query);
        }

        $this->criteria = [];
    }
}
