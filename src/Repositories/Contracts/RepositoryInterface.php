<?php

namespace Sevenpluss\NewsCrud\Repositories\Contracts;

/**
 * Interface RepositoryInterface
 * @package Sevenpluss\NewsCrud\Repositories\Contracts
 */
interface RepositoryInterface
{
    /**
     * @param $id
     * @return \Illuminate\Support\Collection
     */
    public function find($id);

    /**
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function simplePaginate(int $limit);

    /**
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $limit);


    /**
     * @return mixed
     */
    public function createNew();

    /**
     * @param int|string|array $id
     * @return void
     */
    public function destroy($id);
}
