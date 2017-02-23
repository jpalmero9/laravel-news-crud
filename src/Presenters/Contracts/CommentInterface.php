<?php

namespace Sevenpluss\NewsCrud\Presenters\Contracts;

/**
 * Interface CommentInterface
 * @package Sevenpluss\NewsCrud\Presenters\Contracts
 */
interface CommentInterface
{
    /**
     * @return string
     */
    public function getAuthorName();

    /**
     * @return array
     */
    public function getAuthorData();

    /**
     * @return string
     */
    public function getContent();

    /**
     * @param bool $absolute
     * @return mixed
     */
    public function getUri(bool $absolute = false);
}
