<?php

namespace Sevenpluss\NewsCrud\Presenters;

/**
 * Class Presenter
 * @package Sevenpluss\NewsCrud\Presenters
 */
abstract class Presenter
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Presenter constructor.
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->model, $method], $args);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->model->{$name};
    }
}
