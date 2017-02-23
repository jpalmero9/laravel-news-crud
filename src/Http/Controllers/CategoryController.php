<?php

namespace Sevenpluss\NewsCrud\Http\Controllers;

use App\Http\Controllers\Controller;
use Sevenpluss\NewsCrud\Http\Requests\PostIndexRequest;
use Sevenpluss\NewsCrud\Http\Requests\CategoryCreateRequest;
use Sevenpluss\NewsCrud\Http\Requests\CategoryEditRequest;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Repositories\Contracts\PostRepositoryInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\CategoryRepositoryInterface;

/**
 * Class CategoryController
 * @package Sevenpluss\NewsCrud\Http\Controllers
 */
class CategoryController extends Controller
{
    use CommonMethodsForControllers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->prepareHeaderData();

        $breadcrumb = [];

        $breadcrumb[] = ['name' => trans('news::category.index.title')];

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData(['title' => trans('news::category.index.title')]);


        return view('news::category_crud.index', ['categories' => app()->make(CategoryRepositoryInterface::class)->paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->prepareHeaderData();

        $breadcrumb = [];

        $breadcrumb[] = ['url' => route('category.index', [], false), 'name' => trans('news::category.index.title')];
        $breadcrumb[] = ['name' => trans('news::category.create.title')];

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData(['title' => trans('news::category.create.title')]);


        $locales = [];

        foreach (config('translatable.locales') as $locale) {
            $locales[] = ['locale' => $locale];
        }


        return view('news::category_crud.create', [
            'locale' => config('translatable.supported_locales')[app()->getLocale()]['regional'],
            'locales' => $locales,
            'hidden_fields' => [
                ['name' => '_token', 'value' => csrf_token()],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {
        $this->prepareHeaderData();

        $category = app()->make(CategoryRepositoryInterface::class)->createNew();

        $category->active = $request->input('active');

        $category->slug = $request->input('slug');

        $category->name = $request->input('name');

        $category->save();


        \Session::flash('msg', trans('news::category.edit.message_add_success'));

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param PostIndexRequest $request
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(PostIndexRequest $request, string $slug)
    {
        $this->setCurrentCategoryName($slug);

        $this->prepareHeaderData();

        $this->setPageName($slug);

        $meta = [];

        $breadcrumb = [];

        $category = app()->make(CategoryRepositoryInterface::class)->getCategoryDataBySlug($slug);


        if (isset($category['name'])) {

            $meta = ['title' => trans('news::post.meta.title_category', ['category' => $category['name']])];

            $breadcrumb[] = ['url' => route('news.index', [], false), 'name' => trans('news::post.page.index.title')];
            $breadcrumb[] = ['name' => $category['name']];

            $category_name = $category['name'];


        } else {
            $category_name = trans('news::post.page.index.title');
            $breadcrumb[] = ['name' => trans('news::post.page.index.title')];
        }

        $this->prepareMetaData($meta);

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareTagsData('route_category_' . $slug);


        return view('news::category.show', [
            'auth' => $auth = app('auth'),
            'current_route' => FacadesRequest::route()->getName(),
            'category_name' => $category_name,
            'tag_active' => $request->input('tag'),
            'category_id' => $category['id'],
            'posts_paginate' => app()->make(PostRepositoryInterface::class)->categoryPaginate(
                $request->input('limit', 10),
                $request->input('page', 1),
                $category['id'],
                $request->input('author_id'),
                $request->input('tag'),
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
        $breadcrumb = [];

        $breadcrumb[] = ['url' => route('category.index', [], false), 'name' => trans('news::category.index.title')];
        $breadcrumb[] = ['name' => trans('news::category.edit.title')];

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData(['title' => trans('news::category.edit.title')]);


        $category = app()->make(CategoryRepositoryInterface::class)->getDataForEdit($id);

        if (empty($category)) {
            abort(404);
        }

        return view('news::category_crud.edit', [
            'locale' => config('translatable.supported_locales')[app()->getLocale()]['regional'],
            'hidden_fields' => [
                ['name' => 'id', 'value' => $category->id],
                ['name' => '_token', 'value' => csrf_token()],
                ['name' => '_method', 'value' => 'PUT'],
            ],
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryEditRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryEditRequest $request, $id)
    {
        $category = app()->make(CategoryRepositoryInterface::class)->find($id);

        $category->active = $request->input('active');

        $category->slug = $request->input('slug');

        $category->name = $request->input('name');

        $category->save();

        \Session::flash('msg', trans('news::category.edit.message_edit_success'));

        return redirect()->route('category.index');
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
