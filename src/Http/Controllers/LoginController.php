<?php

namespace Sevenpluss\NewsCrud\Http\Controllers;

use App\Http\Controllers\Auth\LoginController as AppLoginController;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\AuthRedirectTo;

/**
 * Class LoginController
 * @package Sevenpluss\NewsCrud\Http\Controllers
 */
class LoginController extends AppLoginController
{
    use CommonMethodsForControllers;

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->prepareHeaderData();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        $meta = ['title' => trans('news::users.meta.login.title')];

        $this->prepareMetaData($meta);

        return view('news::auth.login',
            ['locale' => config('translatable.supported_locales')[app()->getLocale()]['regional']]);
    }

}
