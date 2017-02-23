<?php

namespace Sevenpluss\NewsCrud\Models\Scopes;

use Carbon\Carbon;

/**
 * Class Published
 * @package Sevenpluss\NewsCrud\Models\Scopes
 */
trait Published
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $time_now
     * @return void
     */
    public function scopePublished($query, $time_now = null)
    {
        if (is_null($time_now)) {
            $time_now = Carbon::now();
        }

        $query->whereNotNull('published_at')->where('published_at', '<=', $time_now);
    }
}
