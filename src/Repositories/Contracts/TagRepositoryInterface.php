<?php

namespace Sevenpluss\NewsCrud\Repositories\Contracts;

/**
 * Interface TagRepositoryInterface
 * @package Sevenpluss\NewsCrud\Repositories\Contracts
 */
interface TagRepositoryInterface
{
    /**
     * @param string|bool $is_main_page
     * @return \Illuminate\Support\Collection
     */
    public function sidebarList($is_main_page = false);

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAllForPostEdit();

    /**
     * @param int $post_id
     * @return  \Illuminate\Support\Collection
     */
    public function getSlugsForPost(int $post_id);

}
