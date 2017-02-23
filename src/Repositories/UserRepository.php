<?php

namespace Sevenpluss\NewsCrud\Repositories;

use Illuminate\Database\Eloquent\Relations\Relation;
use Sevenpluss\NewsCrud\Presenters\UserPresenter;
use Sevenpluss\NewsCrud\Repositories\Contracts\UserRepositoryInterface;
use Sevenpluss\NewsCrud\Models\User;

/**
 * Class UserRepository
 * @package Sevenpluss\NewsCrud\Repositories
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * @var \Sevenpluss\NewsCrud\Models\User
     */
    protected $repository;

    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * @param int $id
     * @return array
     */
    public function show(int $id)
    {
        $user = new UserPresenter($this->repository->select(['id', 'name'])->where('id', $id)->with([
            'posts' => function (Relation $query) {
                $query->select(['user_id']);
            },
            'comments' => function (Relation $query) {
                $query->select(['user_id']);
            }
        ])->firstOrFail());

        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'posts' => [
                'count' => $user->posts->count(),
                'url' => route('news.index', ['author_id' => $user->getId()], false),
            ],
            'comments' => [
                'count' => $user->comments->count(),
                'url' => route('comments.index', ['author_id' => $user->getId()], false),
            ],
        ];
    }

    /**
     * @param int $user_id
     * @return string|null
     */
    public function getName(int $user_id)
    {
        return $this->repository->select(['name'])->where('id', $user_id)->get()->pluck('name')->first();
    }

}
