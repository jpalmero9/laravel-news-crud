<?php

namespace Sevenpluss\NewsCrud\Presenters;

use Sevenpluss\NewsCrud\Presenters\Contracts\TimestampInterface;
use Sevenpluss\NewsCrud\Presenters\Contracts\NameInterface;

/**
 * Class UserPresenter
 * @package Sevenpluss\NewsCrud\Presenters
 */
class UserPresenter extends Presenter implements TimestampInterface, NameInterface
{
    /**
     * @var \Sevenpluss\NewsCrud\Models\User
     */
    protected $model;

    /**
     * CategoryPresenter constructor.
     * @param \Sevenpluss\NewsCrud\Models\User $model
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
        return route('user.show', ['id' => $this->getId()], $absolute);
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->model->name;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getCreatedAt()
    {
        return $this->model->created_at;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getUpdatedAt()
    {
        return $this->model->updated_at;
    }
}
