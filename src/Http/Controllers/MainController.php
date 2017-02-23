<?php

namespace Sevenpluss\NewsCrud\Http\Controllers;

use App\Http\Controllers\Controller;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Repositories\Contracts\PostRepositoryInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\CommentRepositoryInterface;

/**
 * Class MainController
 * @package Sevenpluss\NewsCrud\Http\Controllers
 */
class MainController extends Controller
{
    use CommonMethodsForControllers;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->setPageName('main');

        $this->prepareHeaderData();
        $this->prepareMetaData();
        $this->prepareTagsData(true);
    }

    /**
     * Display page home
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('news::home.index', [
            'posts_popular' => app()->make(PostRepositoryInterface::class)->popularPageMain(6),
            'posts_latest' => app()->make(PostRepositoryInterface::class)->latestPageMain(20),
            'comments_latest' => app()->make(CommentRepositoryInterface::class)->latestPageMain(15),
        ]);
    }
}
