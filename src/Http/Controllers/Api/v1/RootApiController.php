<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class RootApiController
 * @package Sevenpluss\NewsCrud\Http\Controllers\Api\v1
 */
class RootApiController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    protected function setApiLocale(Request $request)
    {
        if ($request->has('locale') && in_array($request->input('locale'), config('translatable.locales'))) {
            app()->setLocale($request->input('locale'));
        }
    }

}
