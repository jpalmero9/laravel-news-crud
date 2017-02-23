<?php

namespace Sevenpluss\NewsCrud\Presenters\Contracts;

/**
 * Interface UriInterface
 * @package Sevenpluss\NewsCrud\Presenters\Contracts
 */
interface UriInterface
{
    /**
     * @param bool $absolute
     * @return string
     */
    public function getUri(bool $absolute);

    /**
     * @return string
     */
    public function getSlug();
}
