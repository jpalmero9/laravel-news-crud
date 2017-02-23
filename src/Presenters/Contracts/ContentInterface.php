<?php

namespace Sevenpluss\NewsCrud\Presenters\Contracts;

/**
 * Interface ContentInterface
 * @package Sevenpluss\NewsCrud\Presenters\Contracts
 */
interface ContentInterface
{
    /**
     * @return string
     */
    public function getSummary();

    /**
     * @return string|null
     */
    public function getStory();
}
