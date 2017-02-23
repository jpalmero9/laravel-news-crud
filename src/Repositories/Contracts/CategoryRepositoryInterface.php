<?php

namespace Sevenpluss\NewsCrud\Repositories\Contracts;

/**
 * Interface CategoryRepositoryInterface
 * @package Sevenpluss\NewsCrud\Repositories\Contracts
 */
interface CategoryRepositoryInterface
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headerMenu();

    /**
     * @param int $category_id
     * @return null|string
     */
    public function getCategoryNameByID(int $category_id);

    /**
     * @param string $slug
     * @return null|array
     */
    public function getCategoryDataBySlug(string $slug);

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAllForPostEdit();

    /**
     * @param int $id
     * @return mixed
     */
    public function getDataForEdit(int $id);

    /**
     * @param int|string|array $id
     * @return void
     */
    public function destroy($id);

}
