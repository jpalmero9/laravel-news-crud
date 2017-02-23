<?php

namespace Sevenpluss\NewsCrud\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController as AppRegisterController;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\CommonMethodsForControllers;
use Sevenpluss\NewsCrud\Http\Controllers\Traits\AuthRedirectTo;

/**
 * Class RegisterController
 * @package Sevenpluss\NewsCrud\Http\Controllers
 */
class RegisterController extends AppRegisterController
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
    public function showRegistrationForm()
    {
        $meta = ['title' => trans('news::users.meta.register.title')];

        $this->prepareMetaData($meta);


        return view('news::auth.register',
            ['locale' => config('translatable.supported_locales')[app()->getLocale()]['regional']]);
    }

}
