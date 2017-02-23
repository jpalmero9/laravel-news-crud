<?php

namespace Sevenpluss\NewsCrud\Models;

use Illuminate\Database\Eloquent\Model;
use Sevenpluss\NewsCrud\Models\Scopes\Latest as traitScopeLatest;

/**
 * Class Comment
 * @package Sevenpluss\NewsCrud\Models
 */
class Comment extends Model
{
    use traitScopeLatest;

    /**
     * @var string
     */
    protected $table = 'comments';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'email',
        'name',
        'content'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'post_id' => 'integer',
        'user_id' => 'integer',
        'email' => 'string',
        'name' => 'string',
        'content' => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
