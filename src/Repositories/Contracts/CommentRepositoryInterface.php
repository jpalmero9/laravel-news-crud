<?php

namespace Sevenpluss\NewsCrud\Repositories\Contracts;

/**
 * Interface CommentRepositoryInterface
 * @package Sevenpluss\NewsCrud\Repositories\Contracts
 */
interface CommentRepositoryInterface
{
    /**
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function latestPageMain(int $limit = 5);

    /**
     * @param int $id
     * @param int $page
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginateForPostID(int $id, int $page = 1, int $limit = 10);

    /**
     * @param int $page
     * @param int|null $post_id
     * @param int|null $author_id
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginateIndex(int $page = 1, int $post_id = null, int $author_id = null, int $limit = 10);

}
