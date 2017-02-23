<?php

namespace Sevenpluss\NewsCrud\Repositories\Contracts;

/**
 * Interface UserRepositoryInterface
 * @package Sevenpluss\NewsCrud\Repositories\Contracts
 */
interface UserRepositoryInterface
{
    /**
     * @param int $id
     * @return array
     */
    public function show(int $id);

    /**
     * @param int $user_id
     * @return string|null
     */
    public function getName(int $user_id);

}
