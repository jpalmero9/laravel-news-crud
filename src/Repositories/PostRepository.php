<?php

namespace Sevenpluss\NewsCrud\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\Relation;
use Sevenpluss\NewsCrud\Presenters\CategoryPresenter;
use Sevenpluss\NewsCrud\Presenters\UserPresenter;
use Sevenpluss\NewsCrud\Repositories\Contracts\PostRepositoryInterface;
use Sevenpluss\NewsCrud\Presenters\PostPresenter;
use Sevenpluss\NewsCrud\Presenters\TagPresenter;
use Sevenpluss\NewsCrud\Models\Post;

/**
 * Class PostRepository
 * @package Sevenpluss\NewsCrud\Repositories
 */
class PostRepository extends AbstractRepository implements PostRepositoryInterface
{
    /**
     * @var \Sevenpluss\NewsCrud\Models\Post
     */
    protected $repository;

    /**
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function viewsIncrement(int $id)
    {
        return $this->repository->where('id', '=', $id)->increment('views');
    }

    /**
     * @param int $id
     * @return array
     */
    public function show(int $id)
    {
        $time_now = Carbon::now();

        $post = new PostPresenter($this->repository->select([
            'id',
            'slug',
            'user_id',
            'created_at',
            'updated_at',
            'published_at',
            'category_id',
            'title',
            'description',
            'keywords',
            'name',
            'summary',
            'story',
            'views'
        ])
            ->where('id', $id)
            ->published()
            ->with([
                'tags' => function (Relation $query) {
                    $query->select(['slug', 'name']);
                },
                'user'=> function(Relation $query){
                    $query->select(['id', 'name']);
                },
                'category'=> function(Relation $query){
                    $query->select(['id', 'slug', 'name']);
                }
            ])
            ->firstOrfail());

        $user = new UserPresenter($post->user);

        $category = new CategoryPresenter($post->category);

        return [
            'id' => $post->getId(),
            'slug' => $post->getSlug(),
            'created_at' => $post->getCreatedAt(),
            'updated_at' => $post->getUpdatedAt(),
            'published_at' => $post->getPublishedAt(),
            'published_safe' => $post->getPublishedSafe($time_now),
            'name' => $post->getName(),
            'story' => $post->getStory(),
            'meta' => $post->getMetaAll(),
            'url' => $post->getUri(),
            'author' => [
                'url' => $user->getUri(),
                'name' => $user->getName(),
            ],
            'category' =>[
                'url' => $category->getUri(),
                'name' => $category->getName(),
            ],
            'tags' => $post->tags->present(TagPresenter::class)
                ->transform(function (TagPresenter $tag) {
                    return [
                        'url' => $tag->getUri(),
                        'name' => $tag->getName(),
                    ];
                }),

        ];
    }

    /**
     * @param int $limit
     * @param int $page
     * @param int|null $category_id
     * @param int|null $author_id
     * @param string|null $tag
     * @return LengthAwarePaginator
     */
    public function newsPaginate(
        int $limit = 10,
        int $page = 1,
        int $category_id = null,
        int $author_id = null,
        string $tag = null
    ) {
        if ($page < 1) {
            $page = 1;
        }

        if ($limit < 10) {
            $limit = 10;
        }

        $time_now = Carbon::now();

        $user_auth_check = app('auth')->check();

        // query for page
        $post_query = $this->repository->select([
            'id',
            'slug',
            'user_id',
            'published_at',
            'category_id',
            'name',
            'summary',
        ])
            ->with([
                'tags' => function (Relation $query) {
                    $query->select(['slug', 'name']);
                },
                'user'=> function(Relation $query){
                    $query->select(['id', 'name']);
                },
                'category'=> function(Relation $query){
                    $query->select(['id', 'slug', 'name']);
                }
            ])
            ->published()
            ->orderBy('published_at', 'desc')
            ->skip($limit * ($page - 1))
            ->take($limit);


        // query for count all
        $post_query_all = $this->repository->published();

        // build appends
        $appends = [];

        if ($page > 1) {
            $appends['page'] = $page;
        }

        if ($limit > 10) {
            $appends['limit'] = $limit;
        }

        // add conditions for query and appends for url

        if (!is_null($author_id)) {

            $appends['author_id'] = $author_id;

            $post_query->where('user_id', $author_id);

            $post_query_all->where('user_id', $author_id);
        }


        if (!is_null($category_id)) {

            $appends['category_id'] = $category_id;

            $post_query->where('category_id', $category_id);

            $post_query_all->where('category_id', $category_id);
        }


        if (!is_null($tag)) {

            $appends['tag'] = $tag;

            $post_query->whereHas('tags', function (Builder $query) use ($tag) {
                    $query->select(['slug'])
                        ->where('slug', $tag);

            });

            $post_query_all->whereHas('tags', function (Builder $query) use ($tag) {
                $query->select(['slug'])
                    ->where('slug', $tag);

            });

        }


        // do queries

        $posts = $post_query->get()
            ->present(PostPresenter::class)
            ->map(function (PostPresenter $post) use (
                $time_now,
                $tag,
                $user_auth_check
            ) {

                $user = new UserPresenter($post->user);

                $category = new CategoryPresenter($post->category);

                return [
                    'id' => $post->getId(),
                    'published_at' => $post->getPublishedAt(),
                    'published_safe' => $post->getPublishedSafe($time_now),
                    'name' => $post->getName(),
                    'summary' => $post->getSummary(150),
                    'url' => $post->getUri(),
                    'author' => [
                        'url' => $user->getUri(),
                        'name' => $user->getName(),
                    ],
                    'category' =>[
                        'url' => $category->getUri(),
                        'name' => $category->getName(),
                    ],
                    'tags' => $post->tags->present(TagPresenter::class)->map(function (TagPresenter $item) use ($tag) {
                        return [
                            'url' => route('news.index', ['tag' => $item->getSlug()], false),
                            'name' => $item->getName(),
                            'active' => $item->isActive($tag),
                        ];
                    }),
                    'manage_btn' => $user_auth_check ? $post->getPostManageButtons() : null
                ];
            });


        $route = route('news.index', [], false);

        return new LengthAwarePaginator($posts, $post_query_all->get([\DB::raw(1)])->count(), $limit, $page,
            ['path' => $route, 'query' => $appends]);
    }


    /**
     * @param string|null $route
     * @param int $limit
     * @param int $page
     * @param int|null $category_id
     * @param int|null $author_id
     * @param string|null $tag
     * @return LengthAwarePaginator
     */
    public function tagsPaginate(
        string $route = null,
        int $limit = 10,
        int $page = 1,
        int $category_id = null,
        int $author_id = null,
        string $tag = null
    ) {
        if ($page < 1) {
            $page = 1;
        }

        if ($limit < 10) {
            $limit = 10;
        }

        $time_now = Carbon::now();

        $user_auth_check = app('auth')->check();

        // query for page
        $post_query = $this->repository->select([
            'id',
            'slug',
            'user_id',
            'published_at',
            'category_id',
            'name',
            'summary',
        ])
            ->with([
                'tags' => function (Relation $query) {
                    $query->select(['slug', 'name']);
                },
                'user'=> function(Relation $query){
                    $query->select(['id', 'name']);
                },
                'category'=> function(Relation $query){
                    $query->select(['id', 'slug', 'name']);
                }
            ])
            ->published()
            ->orderBy('published_at', 'desc')
            ->skip($limit * ($page - 1))
            ->take($limit);


        // query for count all
        $post_query_all = $this->repository->select([\DB::raw(1)])
            ->published();


        // build appends
        $appends = [];

        if ($page > 1) {
            $appends['page'] = $page;
        }

        if ($limit > 10) {
            $appends['limit'] = $limit;
        }

        // add conditions for query and appends for url

        if (!is_null($author_id)) {

            $appends['author_id'] = $author_id;

            $post_query->where('user_id', $author_id);

            $post_query_all->where('user_id', $author_id);
        }


        if (!is_null($category_id)) {

            $appends['category_id'] = $category_id;

            $post_query->where('category_id', $category_id);

            $post_query_all->where('category_id', $category_id);
        }


        if (!is_null($tag)) {

            $post_query->whereHas('tags', function (Builder $query) use ($tag) {
                $query->select(['slug'])
                    ->where('slug', $tag);

            });

            $post_query_all->whereHas('tags', function (Builder $query) use ($tag) {
                $query->select(['slug'])
                    ->where('slug', $tag);

            });
        }


        // do queries

        $posts = $post_query->get()
            ->present(PostPresenter::class)
            ->map(function (PostPresenter $post) use (
                $time_now,
                $tag,
                $user_auth_check
            ) {

                $user = new UserPresenter($post->user);

                $category = new CategoryPresenter($post->category);

                return [
                    'id' => $post->getId(),
                    'published_at' => $post->getPublishedAt(),
                    'published_safe' => $post->getPublishedSafe($time_now),
                    'name' => $post->getName(),
                    'summary' => $post->getSummary(150),
                    'url' => $post->getUri(),
                    'author' => [
                        'url' => $user->getUri(),
                        'name' => $user->getName(),
                    ],
                    'category' =>[
                        'url' => $category->getUri(),
                        'name' => $category->getName(),
                    ],
                    'tags' => $post->tags->present(TagPresenter::class)->map(function (TagPresenter $item) use ($tag) {
                        return [
                            'url' => $item->getUri(),
                            'name' => $item->getName(),
                            'active' => $item->isActive($tag),
                        ];
                    }),
                    'manage_btn' => $user_auth_check ? $post->getPostManageButtons() : null
                ];
            });


        if (!empty($tag) && $route == 'tags.show') {
            $route = route($route, ['slug' => $tag], false);
        } else {
            $route = route('tags.index', [], false);
        }

        return new LengthAwarePaginator($posts, $post_query_all->get()->count(), $limit, $page,
            ['path' => $route, 'query' => $appends]);
    }


    /**
     * @param int $limit
     * @param int $page
     * @param int|null $category_id
     * @param int|null $author_id
     * @param string|null $tag
     * @param string|null $category_slug
     * @return LengthAwarePaginator
     */
    public function categoryPaginate(
        int $limit = 10,
        int $page = 1,
        int $category_id = null,
        int $author_id = null,
        string $tag = null,
        string $category_slug = null
    ) {
        if ($page < 1) {
            $page = 1;
        }

        if ($limit < 10) {
            $limit = 10;
        }

        $time_now = Carbon::now();

        $user_auth_check = app('auth')->check();

        // query for page
        $post_query = $this->repository->select([
            'id',
            'slug',
            'user_id',
            'published_at',
            'name',
            'summary',
        ])
            ->with([
                'tags' => function (Relation $query) {
                    $query->select(['slug', 'name']);
                }
            ])
            ->published()
            ->orderBy('published_at', 'desc')
            ->skip($limit * ($page - 1))
            ->take($limit);

        // query for count all
        $post_query_all = $this->repository->select([\DB::raw(1)])
            ->published();


        // build appends
        $appends = [];

        if ($page > 1) {
            $appends['page'] = $page;
        }

        if ($limit > 10) {
            $appends['limit'] = $limit;
        }

        // add conditions for query and appends for url

        if (!is_null($author_id)) {

            $appends['author_id'] = $author_id;

            $post_query->where('user_id', $author_id);

            $post_query_all->where('user_id', $author_id);
        }


        if (!is_null($category_id)) {

            $post_query->where('category_id', $category_id);

            $post_query_all->where('category_id', $category_id);
        }


        if (!is_null($tag)) {

            $appends['tag'] = $tag;

            $post_query->whereHas('tags', function (Builder $query) use ($tag) {
                $query->select(['slug'])
                    ->where('slug', $tag);

            });

            $post_query_all->whereHas('tags', function (Builder $query) use ($tag) {
                $query->select(['slug'])
                    ->where('slug', $tag);

            });

        }


        // do queries

        $posts = $post_query->get()
            ->present(PostPresenter::class)
            ->map(function (PostPresenter $post) use ($time_now, $tag, $user_auth_check, $category_slug) {
                return [
                    'id' => $post->id,
                    'published_at' => $post->getPublishedAt(),
                    'published_safe' => $post->getPublishedSafe($time_now),
                    'name' => $post->getName(),
                    'summary' => $post->getSummary(150),
                    'url' => $post->getUri(),
                    'tags' => $post->tags->present(TagPresenter::class)->map(function (TagPresenter $item) use (
                        $tag,
                        $category_slug
                    ) {
                        return [
                            'url' => $url = route('category.show',
                                ['slug' => $category_slug, 'tag' => $item->getSlug()], false),
                            'name' => $item->getName(),
                            'active' => $item->isActive($tag),
                        ];
                    }),
                    'manage_btn' => $user_auth_check ? $post->getPostManageButtons() : null
                ];
            });


        $route = route('category.show', ['slug' => $category_slug], false);


        return new LengthAwarePaginator($posts, $post_query_all->get()->count(), $limit, $page,
            ['path' => $route, 'query' => $appends]);
    }


    /**
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function popularPageMain(int $limit = 5)
    {
        return $this->repository->select([
            'posts.id',
            'slug',
            'user_id',
            'published_at',
            'posts.name',
            'summary'
        ])->with([
            'tags' => function (Relation $query) {
                $query->select(['slug', 'name']);
            },
            'user'=> function(Relation $query){
                $query->select(['id', 'name']);
            },
        ])
            ->published()
            ->orderBy('views', 'desc')
            ->skip(0)->take($limit)
            ->get()
            ->present(PostPresenter::class)
            ->map(function (PostPresenter $post) {

                return [
                    'published_at' => $post->getPublishedAt(),
                    'name' => $post->getName(),
                    'url' => $post->getUri(),
                    'summary' => $post->getSummary(100),
                    'author' => [
                        'name' => (new UserPresenter($post->user))->getName(),
                    ],
                    'tags' => $post->tags->present(TagPresenter::class)->map(function (TagPresenter $tag) {
                        return [
                            'url' => $tag->getUri(),
                            'name' => $tag->getName()
                        ];
                    }),
                ];
            });
    }

    /**
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function latestPageMain(int $limit = 5)
    {
        $time_now = Carbon::now();

        return $this->repository->published()
            ->orderBy('published_at', 'desc')
            ->skip(0)->take($limit)
            ->get(['id', 'slug', 'published_at', 'name'])
            ->present(PostPresenter::class)
            ->map(function (PostPresenter $post) use ($time_now) {
                return [
                    'published_at' => $post->getPublishedAt(),
                    'is_today_published' => $post->isTodayPublished($time_now),
                    'name' => $post->getName(),
                    'url' => $post->getUri(),
                ];
            });
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function getDataForEdit(int $id)
    {
        $post = $this->repository->select([
            'id',
            'slug',
            'user_id',
            'created_at',
            'updated_at',
            'published_at',
            'category_id as cat_id',
            'title',
            'description',
            'keywords',
            'posts.name',
            'summary',
            'story',
        ])
            ->where('id', $id)
            ->with([
                'tags' => function (Relation $query) {
                    $query->select(['slug']);
                }
            ])
            ->firstOrFail();

        $post->tags = $post->tags->pluck('slug');

        return $post;
    }

}
