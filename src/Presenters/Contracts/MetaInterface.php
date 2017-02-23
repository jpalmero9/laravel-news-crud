<?php

namespace Sevenpluss\NewsCrud\Presenters\Contracts;

/**
 * Interface TranslateAbleInterface
 * @package Sevenpluss\NewsCrud\Presenters\Contracts
 */
interface MetaInterface
{
    /**
     * @return string|null
     */
    public function getMetaTitle();

    /**
     * @return string|null
     */
    public function getMetaDescription();

    /**
     * @return string|null
     */
    public function getMetaKeywords();
}
