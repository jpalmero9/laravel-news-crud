<?php

namespace Sevenpluss\NewsCrud\Presenters\Contracts;

/**
 * Interface TimestampInterface
 * @package Sevenpluss\NewsCrud\Presenters\Contracts
 */
interface TimestampInterface
{
    /**
     * @return \Carbon\Carbon
     */
    public function getCreatedAt();

    /**
     * @return \Carbon\Carbon
     */
    public function getUpdatedAt();

}
