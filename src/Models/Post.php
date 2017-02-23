<?php

namespace Sevenpluss\NewsCrud\Models;

use Illuminate\Database\Eloquent\Model;
use Sevenpluss\NewsCrud\Models\Scopes\Published as traitScopePublished;
use Sevenpluss\NewsCrud\Models\Scopes\Latest as traitScopeLatest;

/**
 * Class Post
 * @package Sevenpluss\NewsCrud\Models
 */
class Post extends Model
{
    use traitScopePublished, traitScopeLatest;

    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $casts = [
        'user_id' => 'interger',
        'category_id' => 'interger',
        'slug' => 'string',
        'title' => 'string',
        'description' => 'string',
        'keywords' => 'string',
        'name' => 'string',
        'summary' => 'string',
        'store' => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', $this->getKeyName());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_slug');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $columns
     * @return void
     */
    public function scopeWithAuthor($query, array $columns = [])
    {
        $query->addSelect($columns)
            ->leftJoin('users', 'users.id', '=', $this->getTable() . '.user_id');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $columns
     * @return void
     */
    public function scopeWithCategory($query, array $columns = [])
    {
        $query->addSelect($columns)
            ->leftJoin('categories', 'categories.id', '=', $this->getTable() . '.category_id');
    }
}
