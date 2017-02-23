<?php

namespace Sevenpluss\NewsCrud\Presenters;

use Carbon\Carbon;
use Sevenpluss\NewsCrud\Presenters\Contracts\UriInterface;
use Sevenpluss\NewsCrud\Presenters\Contracts\MetaInterface;
use Sevenpluss\NewsCrud\Presenters\Contracts\NameInterface;
use Sevenpluss\NewsCrud\Presenters\Contracts\ContentInterface;
use Sevenpluss\NewsCrud\Presenters\Contracts\ManageButtonsInterface;

/**
 * Class PostPresenter
 * @package Sevenpluss\NewsCrud\Presenters
 */
class PostPresenter extends Presenter implements UriInterface, NameInterface, ContentInterface, MetaInterface, ManageButtonsInterface
{
    /**
     * /**
     * @var \Sevenpluss\NewsCrud\Models\Post
     */
    protected $model;

    /**
     * CategoryPresenter constructor.
     * @param \Sevenpluss\NewsCrud\Models\Post $model
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
     * @param bool $absolute
     * @return string
     */
    public function getUri(bool $absolute = false)
    {
        return route('news.show', ['id' => $this->getId(), 'slug' => $this->getSlug()], $absolute);
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->model->slug;
    }

    /**
     * @return array
     */
    public function getMetaAll()
    {
        $meta = [
            'title' => $this->getMetaTitle()
        ];

        if (!is_null($this->getMetaDescription())) {
            $meta['description'] = $this->getMetaDescription();
        }

        if (!is_null($this->getMetaKeywords())) {
            $meta['keywords'] = $this->getMetaKeywords();
        }

        return $meta;
    }

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        return !is_null($this->model->title) ? $this->model->title : $this->getName();
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return !is_null($this->model->description) ? $this->model->description : $this->getSummary(155, '');
    }

    /**
     * @return string|null
     */
    public function getMetaKeywords()
    {
        return $this->model->keywords;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->model->name;
    }

    /**
     * @param int|null $str_limit
     * @param string $ends
     * @return string
     */
    public function getSummary(int $str_limit = null, $ends = '...')
    {
        return !is_null($str_limit) ? str_limit($this->model->summary, $str_limit, $ends) : $this->model->summary;
    }

    /**
     * @return string|null
     */
    public function getStory()
    {
        return !is_null($this->model->story) ? $this->model->story : $this->model->summary;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt()
    {
        return $this->model->created_at;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt()
    {
        return $this->model->updated_at;
    }

    /**
     * @return Carbon|null
     */
    public function getPublishedAt()
    {
        return $this->model->published_at;
    }

    /**
     * @param  $time_now
     * @return bool
     */
    public function isTodayPublished(Carbon $time_now)
    {
        return $this->model->published_at->diff($time_now)->days < 1 ? true : false;
    }

    /**
     * @param Carbon $time_now
     * @return mixed
     */
    public function getPublishedSafe(Carbon $time_now)
    {
        return $this->model->published_at->format(trans($this->isTodayPublished($time_now) ? 'news::config.time' : 'news::config.datetime'));
    }


    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->model->user->name;
    }

    /**
     * @return string
     */
    public function getAuthorUrl(){
        return route('user.show', ['id'=> $this->model->user_id], false);
    }

    /**
     * @return array
     */
    public function getCategory()
    {
        return [
            'url' => route('category.show', ['slug' => $this->model->category_slug], false),
            'name' => $this->model->category_name,
        ];
    }

    /**
     * @return array
     */
    public function getPostManageButtons()
    {
        return [
            'edit' => route('news.edit', ['slug' => $this->model->id], false),
            'delete' => true,
        ];
    }

}
