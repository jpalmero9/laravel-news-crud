<?php

namespace Sevenpluss\NewsCrud\Models;

use Illuminate\Database\Eloquent\Model;
use Sevenpluss\NewsCrud\Models\Scopes\Active as traitScopeActive;

/**
 * Class Tag
 * @package Sevenpluss\NewsCrud\Models
 */
class Tag extends Model
{
    use traitScopeActive;

    /**
     * @var string
     */
    protected $table = 'tags';

    /**
     * @var string
     */
    protected $primaryKey = 'slug';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
        'active',
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
     * @param int|string|null|bool $value
     * @return void
     */
    public function setActiveAttribute($value)
    {
        if ((is_string($value) && strtolower($value) != 'no')
            || (is_bool($value) && $value == true)
            || (is_int($value) && $value > 0)
        ) {
            $this->attributes['active'] = 1;
        } else {
            $this->attributes['active'] = null;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags', 'tag_slug', 'post_id');
    }
}
