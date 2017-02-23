<?php

namespace Sevenpluss\NewsCrud\Repositories;

use Illuminate\Database\Eloquent\Relations\Relation;
use Sevenpluss\NewsCrud\Repositories\Contracts\CommentRepositoryInterface;
use Sevenpluss\NewsCrud\Presenters\CommentPresenter;
use Sevenpluss\NewsCrud\Models\Comment;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class CategoryRepository
 * @package Sevenpluss\NewsCrud\Repositories
 */
class CommentRepository extends AbstractRepository implements CommentRepositoryInterface
{
    /**
     * @var \Sevenpluss\NewsCrud\Models\Comment
     */
    protected $repository;

    /**
     * @return string
     */
    public function model()
    {
        return Comment::class;
    }

    /**
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function latestPageMain(int $limit = 5)
    {
        $time_now = Carbon::now();

        return $this->repository->select([
            'id',
            'user_id',
            'post_id',
            'name as guest_name',
            'created_at',
            'content'
        ])
            ->orderBy('created_at', 'desc')
            ->with(['user'=> function(Relation $query){
                $query->select(['id', 'name']);
            }, 'post'=> function(Relation $query){
                $query->select(['id', 'slug']);
            }])
            ->skip(0)->take($limit)
            ->get()
            ->present(CommentPresenter::class)
            ->map(function (CommentPresenter $comment) use ($time_now) {
                return [
                    'created_at' => $comment->getCreatedAt(),
                    'created_safe' => $comment->getCreatedSafe($time_now),
                    'content' => $comment->getContent(),
                    'author' => $comment->getAuthorName(),
                    'post_url' => route('news.show', ['id' => $comment->post_id, 'slug' => $comment->post->slug],
                        false),
                ];
            });
    }

    /**
     * @param int $id
     * @param int $page
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function paginateForPostID(int $id, int $page = 1, int $limit = 10)
    {
        if ($page < 1) {
            $page = 1;
        }

        $comments = $this->repository->select([
            'id',
            'user_id',
            'name as guest_name',
            'email as guest_email',
            'created_at',
            'content'
        ])
            ->with(['user'=> function(Relation $query){
                $query->select(['id', 'name']);
            }])
            ->where('post_id', $id)
            ->orderBy('created_at', 'desc')
            ->skip($limit * ($page - 1))
            ->take($limit)
            ->get()
            ->present(CommentPresenter::class)
            ->map(function (CommentPresenter $comment) {
                return [
                    'created_at' => $comment->getCreatedAt(),
                    'content' => $comment->getContent(),
                    'author' => $comment->getAuthorData(),
                ];
            });


        // query for count all
        $comments_all = $this->repository->select([\DB::raw(1)])
            ->where('post_id', $id)
            ->get()->count();


        // build paginator
        $appends = [];

        if ($page > 1) {
            $appends['page'] = $page;
        }


        return new LengthAwarePaginator($comments, $comments_all, $limit, $page,
            ['path' => Paginator::resolveCurrentPath(), 'query' => $appends]);
    }


    /**
     * @param int $page
     * @param int|null $post_id
     * @param int|null $author_id
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function paginateIndex(int $page = 1, int $post_id = null, int $author_id = null, int $limit = 10)
    {
        if ($page < 1) {
            $page = 1;
        }

        $query = $this->repository->select([
            'id',
            'user_id',
            'name as guest_name',
            'email as guest_email',
            'created_at',
            'content'
        ])
            ->with(['user'=> function(Relation $query){
                $query->select(['id', 'name']);
            }])
            ->orderBy('created_at', 'desc')
            ->skip($limit * ($page - 1))
            ->take($limit);

        $query_all = $this->repository->select([\DB::raw(1)]);


        $appends = [];

        if (!is_null($author_id)) {

            $appends['author_id'] = $author_id;

            $query->where('user_id', $author_id);
            $query_all->where('user_id', $author_id);
        }


        if (!is_null($post_id)) {

            $appends['post_id'] = $author_id;

            $query->where('post_id', $post_id);
            $query_all->where('post_id', $post_id);
        }


        $comments = $query->get()
            ->present(CommentPresenter::class)
            ->map(function (CommentPresenter $comment) {
                return [
                    'created_at' => $comment->getCreatedAt(),
                    'content' => $comment->getContent(),
                    'author' => $comment->getAuthorData(),
                ];
            });


        // query for count all
        $comments_all = $query_all->get()->count();


        // build paginator
        if ($page > 1) {
            $appends['page'] = $page;
        }

        if ($limit > 10) {
            $appends['limit'] = $limit;
        }

        return new LengthAwarePaginator($comments, $comments_all, $limit, $page,
            ['path' => route('comments.index', [], false), 'query' => $appends]);
    }

}
