<?php

namespace Sevenpluss\NewsCrud\Repositories\Contracts;

/**
 * Interface PostRepositoryInterface
 * @package Sevenpluss\NewsCrud\Repositories\Contracts
 */
interface PostRepositoryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function viewsIncrement(int $id);

    /**
     * @param int $id
     * @return array
     */
    public function show(int $id);

    /**
     * @param int $limit
     * @param int $page
     * @param int|null $category_id
     * @param int|null $author_id
     * @param string|null $tag
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function newsPaginate(
        int $limit = 10,
        int $page = 1,
        int $category_id = null,
        int $author_id = null,
        string $tag = null
    );

    /**
     * @param string|null $route
     * @param int $limit
     * @param int $page
     * @param int|null $category_id
     * @param int|null $author_id
     * @param string|null $tag
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function tagsPaginate(
        string $route = null,
        int $limit = 10,
        int $page = 1,
        int $category_id = null,
        int $author_id = null,
        string $tag = null
    );

    /**
     * @param int $limit
     * @param int $page
     * @param int|null $category_id
     * @param int|null $author_id
     * @param string|null $tag
     * @param string|null $category_slug
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function categoryPaginate(
        int $limit = 10,
        int $page = 1,
        int $category_id = null,
        int $author_id = null,
        string $tag = null,
        string $category_slug = null
    );

    /**
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function popularPageMain(int $limit = 5);

    /**
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function latestPageMain(int $limit = 5);

    /**
     * @param int $id
     * @return mixed
     */
    public function getDataForEdit(int $id);
}
