<?php


namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filters
{

    /**
     * @var Request
     */
    protected $request;
    protected $builder;
    protected $filters = [];

    /**
     * ThreadFilters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {

            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function getFilters()
    {
        // return $this->request->intersect($this->filters);
        return array_filter($this->request->only($this->filters));
    }

    /**
     * @param $filter
     * @return bool
     */
    protected function hasFilter($filter): bool
    {
        return method_exists($this, $filter) && $this->request->has($filter);
    }
}