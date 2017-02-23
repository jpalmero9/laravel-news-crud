<?php

namespace Sevenpluss\NewsCrud\Presenters;

use Sevenpluss\NewsCrud\Presenters\Contracts\UriInterface;
use Sevenpluss\NewsCrud\Presenters\Contracts\MetaInterface;
use Sevenpluss\NewsCrud\Presenters\Contracts\NameInterface;

/**
 * Class CategoryPresenter
 * @package Sevenpluss\NewsCrud\Presenters
 */
class CategoryPresenter extends Presenter implements UriInterface, NameInterface, MetaInterface
{
    /**
     * @var \Sevenpluss\NewsCrud\Models\Category
     */
    protected $model;

    /**
     * CategoryPresenter constructor.
     * @param \Sevenpluss\NewsCrud\Models\Category $model
     */
    public function __construct($model)
    {
        parent::__construct($model);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->model->id;
    }

    /**
     * @return string
     */
    public function getUri(bool $absolute = false)
    {
        return route('category.show', ['slug' => $this->model->slug], $absolute);
    }

    /**
     * @return string|null
     */
    public function getSlug()
    {
        return $this->model->slug;
    }

    /**
     * @return string|null
     */
    public function getMetaTitle()
    {
        return $this->model->title;
    }

    /**
     * @return string|null
     */
    public function getMetaDescription()
    {
        return $this->model->description;
    }

    /**
     * @return string|null
     */
    public function getMetaKeywords()
    {
        return $this->model->keywords;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->model->name;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return (bool)$this->model->active;
    }

}
