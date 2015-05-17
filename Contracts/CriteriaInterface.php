<?php namespace Sahib\Elegan\Contracts;

/**
 * Interface CriteriaInterface
 *
 * @package Sahib\Elegan\Contracts
 */
interface CriteriaInterface
{
    /**
     * Apply a criteria to the query.
     *
     * @param mixed $query
     * @return mixed
     */
    public function apply($query);
}
