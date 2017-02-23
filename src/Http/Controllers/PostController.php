<?php

namespace Sevenpluss\NewsCrud\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sevenpluss\NewsCrud\Http\Requests\PostIndexRequest;
use Sevenpluss\NewsCrud\Http\Requests\PostCommentsRequest;
use Sevenpluss\NewsCrud\Http\Requests\PostCreateRequest;
use Sevenpluss\NewsCrud\Http\Requests\PostEditRequest;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Repositories\Contracts\PostRepositoryInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\CommentRepositoryInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\CategoryRepositoryInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\TagRepositoryInterface;

/**
 * Class PostController
 * @package Sevenpluss\NewsCrud\Http\Controllers
 */
class PostController extends Controller
{
    use CommonMethodsForControllers;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->setPageName('news');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PostIndexRequest $request)
    {
        $meta = [];

        $breadcrumb = [];

        $category_name = trans('news::post.page.index.title');

        if ($request->has('category_id')) {

            $category_name = app()->make(CategoryRepositoryInterface::class)->getCategoryNameByID($request->input('category_id'));

            if (!is_null($category_name)) {

                $meta = ['title' => trans('news::post.meta.title_category', ['category' => $category_name])];

                $breadcrumb[] = [
                    'url' => route('news.index', [], false),
                    'name' => trans('news::post.page.index.title')
                ];
                $breadcrumb[] = ['name' => $category_name];

            } else {
                $breadcrumb[] = ['name' => trans('news::post.page.index.title')];
            }

        } else {
            $breadcrumb[] = ['name' => trans('news::post.page.index.title')];
        }


        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareHeaderData();

        $this->prepareMetaData($meta);

        $this->prepareTagsData('route_news');


        return view('news::post.index', [
            'auth' => $auth = app('auth'),
            'current_route' => 'news.index',
            'tag_active' => $request->input('tag'),
            'category_name' => $category_name,
            'posts_paginate' => app()->make(PostRepositoryInterface::class)->newsPaginate(
                $request->input('limit', 10),
                $request->input('page', 1),
                $request->input('category_id'),
                $request->input('author_id'),
                $request->input('tag')
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->middleware('auth');

        $this->prepareHeaderData();

        $breadcrumb = [];

        $breadcrumb[] = ['url' => route('news.index', [], false), 'name' => trans('news::post.page.index.title')];
        $breadcrumb[] = ['name' => trans('news::post.page.create.title')];

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData(['title' => trans('news::post.page.create.title')]);

        $locales = [];

        foreach (config('translatable.locales') as $locale) {
            $locales[] = ['locale' => $locale];
        }

        return view('news::post.create', [
            'locale' => config('translatable.supported_locales')[app()->getLocale()]['regional'],
            'locales' => $locales,
            'hidden_fields' => [
                ['name' => 'user_id', 'value' => app('auth')->user()->id],
                ['name' => '_token', 'value' => csrf_token()],
            ],
            'form' => [
                'categories' => app(CategoryRepositoryInterface::class)->getAllForPostEdit(),
                'tags' => app(TagRepositoryInterface::class)->getAllForPostEdit(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostCreateRequest $request)
    {
        $this->middleware('auth');


        $post = app()->make(PostRepositoryInterface::class)->createNew();

        if ($request->has('published_now')) {

            $post->published_at = Carbon::now();

        } else {
            $post->published_at = $request->input('published_at');
        }

        $post->category_id = $request->input('category_id');
        $post->user_id = app('auth')->user()->id;

        $post->slug = $request->input('slug');


        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->keywords = $request->input('keywords');

        $post->name = $request->input('name');
        $post->summary = $request->input('summary');
        $post->story = $request->input('story');


        $post->save();


        if ($request->has('tags') && is_array($request->input('tags'))) {
            $post->tags()->sync($request->input('tags'));
        } else {
            $post->tags()->sync([]);
        }


        \Session::flash('msg', trans('news::post.page.edit.message_edit_success'));

        return redirect()->route('news.index');
    }

    /**
     * @param PostCommentsRequest $request
     * @param int $id
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(PostCommentsRequest $request, int $id, string $slug)
    {
        $post = app()->make(PostRepositoryInterface::class)->show($id);

        if (!empty($post)) {

            if ($post['slug'] != $slug) {

                return redirect()->route('news.show', ['id' => $post['id'], 'slug' => $post['slug']]);

            } else {

                app()->make(PostRepositoryInterface::class)->viewsIncrement($id);

                $breadcrumb = [];

                $breadcrumb[] = [
                    'url' => route('news.index', [], false),
                    'name' => trans('news::post.page.index.title')
                ];
                $breadcrumb[] = ['url' => $post['category']['url'], 'name' => $post['category']['name']];
                $breadcrumb[] = ['name' => $post['name']];

                $this->prepareBreadcrumbData($breadcrumb);

                $this->prepareHeaderData();

                $this->prepareTagsData();

                $this->prepareMetaData($post['meta']);

                unset($post['meta']);


                view()->composer('news::post.comment_add', function ($view) use ($id) {


                    $hidden_fields = [];
                    $hidden_fields[] = ['name' => 'post_id', 'value' => $id];
                    if (app('auth')->check()) {
                        $hidden_fields[] = ['name' => 'user_id', 'value' => app('auth')->user()->id];
                    }
//
                    $locale = config('translatable.supported_locales')[app()->getLocale()]['regional'];

                    $auth = app('auth');

                    return $view->with(compact('hidden_fields', 'locale', 'auth'));
                });
            }

        } else {
            abort(404);
        }

        return view('news::post.show', [
            'post' => $post,
            'comments' => app()->make(CommentRepositoryInterface::class)->paginateForPostID($id, $request->input('page', 1)),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->middleware('auth');

        $breadcrumb = [];

        $breadcrumb[] = ['url' => route('news.index', [], false), 'name' => trans('news::post.page.index.title')];
        $breadcrumb[] = ['name' => trans('news::post.page.edit.title')];

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData(['title' => trans('news::post.page.edit.title')]);

        $this->prepareHeaderData();


        $post = app()->make(PostRepositoryInterface::class)->getDataForEdit($id);

        if (empty($post)) {
            abort(404);
        }

        return view('news::post.edit', [
            'locale' => config('translatable.supported_locales')[app()->getLocale()]['regional'],
            'hidden_fields' => [
                ['name' => 'id', 'value' => $post->id],
                ['name' => 'user_id', 'value' => app('auth')->user()->id],
                ['name' => '_token', 'value' => csrf_token()],
                ['name' => '_method', 'value' => 'PUT'],
            ],
            'form' => [
                'categories' => app()->make(CategoryRepositoryInterface::class)->getAllForPostEdit(),
                'tags' => app()->make(TagRepositoryInterface::class)->getAllForPostEdit(),
            ],
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostEditRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostEditRequest $request, int $id)
    {
        $this->middleware('auth');

        if ($id == $request->input('id')) {

            $post = app()->make(PostRepositoryInterface::class)->find($id);

            if ($request->has('published_now')) {

                $post->published_at = Carbon::now();

            } else {
                $post->published_at = $request->input('published_at');
            }

            $post->category_id = $request->input('category_id');

            $post->slug = $request->input('slug');


            if ($request->has('tags') && is_array($request->input('tags'))) {
                $post->tags()->sync($request->input('tags'));
            } else {
                $post->tags()->sync([]);
            }


            $post->title = $request->input('title');
            $post->description = $request->input('description');
            $post->keywords = $request->input('keywords');

            $post->name = $request->input('name');
            $post->summary = $request->input('summary');
            $post->story = $request->input('story');

            $post->save();


            \Session::flash('msg', trans('news::post.page.edit.message_edit_success'));
        }

        return redirect()->route('news.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
