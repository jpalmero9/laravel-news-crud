<?php
namespace Sevenpluss\NewsCrud\Models;

use App\User as AppUser;

/**
 * Class User
 * @package Sevenpluss\NewsCrud\Models
 */
class User extends AppUser
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', $this->getKeyName());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', $this->getKeyName());
    }
}
