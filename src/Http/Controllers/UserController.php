<?php

namespace Sevenpluss\NewsCrud\Http\Controllers;

use App\Http\Controllers\Controller;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Repositories\Contracts\UserRepositoryInterface;

/**
 * Class CommentController
 * @package Sevenpluss\NewsCrud\Http\Controllers
 */
class UserController extends Controller
{
    use CommonMethodsForControllers;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->setPageName('user');

        $this->prepareHeaderData();
        $this->prepareMetaData();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = app()->make(UserRepositoryInterface::class)->show($id);

        if(is_null($user)){
            abort(404);
        }

        $breadcrumb = [];

        $breadcrumb[] = ['name' => trans('news::users.page.show.breadcrumb', ['name'=> $user['name']])];

        $this->prepareBreadcrumbData($breadcrumb);

        $this->prepareMetaData(['title' => trans('news::users.page.show.meta.title', ['name'=> $user['name']])]);

        return view('news::user.show', compact('user'));
    }
}
