<?php

Route::post('post/pagination-news',
    ['as' => 'api.post_pagination.news', 'uses' => 'Api\v1\PostController@paginationNews'])
    ->where(['locale' => '(' . implode('|', config('translatable.locales')) . ')']);

Route::post('post/pagination-category',
    ['as' => 'api.post_pagination.category', 'uses' => 'Api\v1\PostController@paginationCategory'])
    ->where(['slug' => 'a-z0-9\-', 'locale' => '(' . implode('|', config('translatable.locales')) . ')']);

Route::post('post/pagination-tags',
    ['as' => 'api.post_pagination.tags', 'uses' => 'Api\v1\PostController@paginationTags'])
    ->where(['slug' => 'a-z0-9\-', 'locale' => '(' . implode('|', config('translatable.locales')) . ')']);

Route::post('post/destroy',
    ['as' => 'api.post_destroy', 'uses' => 'Api\v1\PostController@destroy']);

Route::post('post/comment-add', ['as' => 'api.post_comment.add', 'uses' => 'Api\v1\CommentController@store'])
    ->where(['locale' => '(' . implode('|', config('translatable.locales')) . ')']);

Route::post('post/comments-latest', ['as' => 'api.post_comment.latest', 'uses' => 'Api\v1\CommentController@latest']);

Route::post('post/comments-index', ['as' => 'api.comments_pagination.index', 'uses' => 'Api\v1\CommentController@latest']);

Route::post('category/destroy',
    ['as' => 'api.category_destroy', 'uses' => 'Api\v1\CategoryController@destroy']);
