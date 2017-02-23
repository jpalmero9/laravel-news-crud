<?php

Route::get('/', ['as' => 'home', 'uses' => 'MainController']);
Route::get('home', function () {
    return redirect()->route('home');
});

Route::get('register', ['as' => 'register.create', 'uses' => 'RegisterController@showRegistrationForm']);
Route::post('register', ['as' => 'register.store', 'uses' => 'RegisterController@register']);

Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
Route::post('login', ['as' => 'login', 'uses' => 'LoginController@login']);
Route::get('logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);


Route::resource('tags', 'TagController', ['only' => 'index']);
Route::get('tags/{slug}', ['as' => 'tags.show', 'uses' => 'TagController@show']);

Route::resource('category', 'CategoryController');

Route::resource('news', 'PostController', ['except' => 'show']);
Route::get('news/{id}-{slug}', ['as' => 'news.show', 'uses' => 'PostController@show']);

Route::resource('comments', 'CommentController', ['only' => 'index']);
Route::resource('user', 'UserController', ['only' => 'show']);
