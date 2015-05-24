<?php
/**
 * @author Sahib J. Leo <sahib@sahib.io>
 * Date: 5/19/15, 8:24 PM
 */

namespace Sahib\Elegan\Repositories\Eloquent;

class ResourceRepository extends Repository
{
    /**
     * @var string
     */
    private $model;

    /**
     * @param string $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get model's name.
     *
     * @return string
     */
    protected function model()
    {
        return $this->model;
    }
}
