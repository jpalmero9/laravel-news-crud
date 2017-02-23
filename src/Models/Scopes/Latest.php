<?php

namespace Sevenpluss\NewsCrud\Models\Scopes;

/**
 * Class Latest
 * @package Sevenpluss\NewsCrud\Models\Scopes
 */
trait Latest
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function scopeLatest($query)
    {
        $query->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc');
    }
}