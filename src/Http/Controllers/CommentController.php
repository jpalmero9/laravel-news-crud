<?php

namespace Sevenpluss\NewsCrud\Http\Controllers;

use App\Http\Controllers\Controller;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Http\Requests\CommentsIndexRequest;
use Sevenpluss\NewsCrud\Repositories\Contracts\CommentRepositoryInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\UserRepositoryInterface;

/**
 * Class CommentController
 * @package Sevenpluss\NewsCrud\Http\Controllers
 */
class CommentController extends Controller
{
    use CommonMethodsForControllers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommentsIndexRequest $request, CommentRepositoryInterface $commentRepo)
    {
        $this->prepareHeaderData();

        $category_name = null;

        if($request->input('author_id')){
            $category_name = app()->make(UserRepositoryInterface::class)->getName($request->input('author_id'));
        }

        $category_name = !is_null($category_name) ? trans('news::comments.index.title_name', ['name'=> $category_name]) : trans('news::comments.index.title_all');

        $breadcrumb = [];

        $breadcrumb[] = [
            'url' => route('news.index', [], false),
            'name' => trans('news::post.page.index.title')
        ];

        $breadcrumb[] = ['name' => $category_name];

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData(['title' => trans('news::category.index.title')]);


        return view('news::comments.index', [
            'auth' => $auth = app('auth'),
            'category_name' => $category_name,
            'comments' => $commentRepo->paginateIndex(
                $request->input('page', 1),
                $request->input('post_id'),
                $request->input('author_id'),
                $request->input('limit', 10)
            ),
        ]);
    }

}
