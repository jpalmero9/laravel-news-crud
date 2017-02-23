<?php

namespace Sevenpluss\NewsCrud\Models;

use Illuminate\Database\Eloquent\Model;
use Sevenpluss\NewsCrud\Models\Scopes\Active as traitScopeActive;

/**
 * Class Category
 * @package Sevenpluss\NewsCrud\Models
 */
class Category extends Model
{
    use traitScopeActive;

    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
        'active'
    ];

    /**
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'active'];

    /**
     * @var array
     */
    protected $casts = [
        'slug' => 'string',
        'name' => 'string',
        'active' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', $this->getKeyName());
    }
}
