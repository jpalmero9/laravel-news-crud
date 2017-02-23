<?php

namespace Sevenpluss\NewsCrud\Models\Scopes;

/**
 * Class Active
 * @package Sevenpluss\NewsCrud\Models\Scopes
 */
trait Active
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function scopeActive($query)
    {
        $query->whereNotNull('active');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param bool $active
     * @return void
     */
    public function scopeActiveIt($query, bool $active = true)
    {
        $active ? $query->whereNotNull('active') : $query->whereNull('active');
    }
}
