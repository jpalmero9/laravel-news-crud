<?php

namespace Sevenpluss\NewsCrud\Presenters;

use Carbon\Carbon;
use Sevenpluss\NewsCrud\Presenters\Contracts\CommentInterface;

/**
 * Class CategoryPresenter
 * @package Sevenpluss\NewsCrud\Presenters
 */
class CommentPresenter extends Presenter implements CommentInterface
{
    /**
     * @var \Sevenpluss\NewsCrud\Models\Comment
     */
    protected $model;

    /**
     * CategoryPresenter constructor.
     * @param \Sevenpluss\NewsCrud\Models\Comment $model
     */
    public function __construct($model)
    {
        parent::__construct($model);
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return !is_null($this->model->user_id) && !is_null($this->model->user->name) ? $this->model->user->name : $this->model->guest_name;
    }

    /**
     * @return array
     */
    public function getAuthorData()
    {
        return [
            'name' => $this->getAuthorName(),
            'url' => !is_null($this->model->user_id) ? route('user.show', ['id' => $this->model->user_id],
                false) : null,
        ];
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->model->content;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt()
    {
        return $this->model->created_at;
    }

    /**
     * @return string
     */
    public function getCreatedSafe(Carbon $time_now)
    {
        return $this->model->created_at->format(trans('news::config.datetime'));
    }

    /**
     * @param bool $absolute
     * @return string
     */
    public function getUri(bool $absolute = false)
    {
        return route('comments.show', ['id' => $this->model->id], $absolute);
    }

}
