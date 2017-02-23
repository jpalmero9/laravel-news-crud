<?php

namespace Sevenpluss\NewsCrud\Http\Controllers;

use App\Http\Controllers\Controller;
use Sevenpluss\NewsCrud\Http\Requests\TagsIndexShowRequest;
use Illuminate\Http\Request;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Repositories\Contracts\PostRepositoryInterface;

/**
 * Class TagController
 * @package Sevenpluss\NewsCrud\Http\Controllers
 */
class TagController extends Controller
{
    use CommonMethodsForControllers;

    /**
     * @var array|null
     */
    protected $repository;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->setPageName('tags');
    }

    /**
     * @param TagsIndexShowRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(TagsIndexShowRequest $request)
    {
        $category_name = trans('news::tags.page.title');

        $meta = [
            'title' => $category_name
        ];

        $breadcrumb = [];
        $breadcrumb[] = ['name' => $category_name];

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareHeaderData();

        $this->prepareMetaData($meta);

        $this->prepareTagsData(true);


        return view('news::tags.index_show', [
            'auth' => $auth = app('auth'),
            'current_route' => 'tags.index',
            'tag_active' => null,
            'category_name' => $category_name,
            'posts_paginate' => app()->make(PostRepositoryInterface::class)->tagsPaginate(
                'tags.index',
                $request->input('limit', 10),
                $request->input('page', 1),
                $request->input('category_id'),
                $request->input('author_id')
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param TagsIndexShowRequest $request
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function show(TagsIndexShowRequest $request, string $slug)
    {
        $category_name = trans('news::tags.page.title');

        $meta = [
            'title' => trans('news::post.meta.title_category', ['category' => $category_name])
        ];


        $breadcrumb = [];
        $breadcrumb[] = ['name' => trans('news::tags.page.title')];

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareHeaderData();

        $this->prepareMetaData($meta);

        $this->prepareTagsData(true);


        return view('news::tags.index_show', [
            'auth' => $auth = app('auth'),
            'current_route' => 'tags.show',
            'tag_active' => $slug,
            'category_name' => $category_name,
            'posts_paginate' => app()->make(PostRepositoryInterface::class)->tagsPaginate(
                'tags.show',
                $request->input('limit', 10),
                $request->input('page', 1),
                $request->input('category_id'),
                $request->input('author_id'),
                $slug
            ),
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
