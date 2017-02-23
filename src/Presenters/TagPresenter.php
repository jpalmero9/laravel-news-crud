<?php

namespace Sevenpluss\NewsCrud\Presenters;

use Sevenpluss\NewsCrud\Presenters\Contracts\UriInterface;
use Sevenpluss\NewsCrud\Presenters\Contracts\NameInterface;

/**
 * Class TagPresenter
 * @package Sevenpluss\NewsCrud\Presenters
 */
class TagPresenter extends Presenter implements UriInterface, NameInterface
{
    /**
     * @var \Sevenpluss\NewsCrud\Models\Tag
     */
    protected $model;

    /**
     * CategoryPresenter constructor.
     * @param \Sevenpluss\NewsCrud\Models\Tag $model
     */
    public function __construct($model)
    {
        parent::__construct($model);
    }

    /**
     * @param string|bool $is_main_page
     * @param bool $absolute
     * @return string
     */
    public function getUriForBox($is_main_page = false, bool $absolute = false)
    {
        return is_bool($is_main_page) ? route('tags.show', ['slug' => $this->model->slug],
            $absolute) : url()->current() . '?tag=' . $this->getSlug();
    }

    /**
     * @param bool $absolute
     * @return string
     */
    public function getUri(bool $absolute = false)
    {
        return route('tags.show', ['slug' => $this->model->slug], $absolute);
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
    public function getName()
    {
        return $this->model->name;
    }

    /**
     * @param string|null $tag
     * @return bool
     */
    public function isActive(string $tag = null)
    {
        return !is_null($tag) && $tag == $this->getSlug();
    }
}
