<?php

namespace Sevenpluss\NewsCrud\Repositories;

use Illuminate\Database\Eloquent\Model;
use Sevenpluss\NewsCrud\Repositories\Contracts\RepositoryInterface;
use Sevenpluss\NewsCrud\Exceptions\RepositoryException;

/**
 * Class AbstractRepository
 * @package Sevenpluss\NewsCrud\Repositories
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $repository;

    /**
     * AbstractRepository constructor.
     */
    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * Boot methods
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * @return string
     */
    abstract public function model();

    /**
     * @return \Illuminate\Database\Eloquent\Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = app()->make($this->model());
        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $this->repository = $model;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param string $key
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function findByKey(string $key, $value)
    {
        return $this->repository->where($key, $value);
    }

    /**
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function simplePaginate(int $limit = 12)
    {
        return $this->repository->simplePaginate($limit);
    }

    /**
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $limit = 12)
    {
        return $this->repository->paginate($limit);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createNew()
    {
        return new $this->repository;
    }

    /**
     * @param int|string|array $id
     * @return void
     */
    public function destroy($id)
    {
        $this->repository->destroy($id);
    }
}
