<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Traits;

/**
 * Class AuthRedirectTo
 * @package Sevenpluss\NewsCrud\Http\Controllers\Traits
 */
trait AuthRedirectTo
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectTo()
    {
        return redirect()->route('home');
    }
}
