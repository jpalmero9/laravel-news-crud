<?php

return [
    'form_inputs' => [
        'name' => 'First Name',
        'email' => 'Your Email',
        'password' => 'Password',
        'password_confirmation' => 'Repeat Password',
        'remember' => 'Remember Me',
    ],

    'validate_messages' => [
        'name' => [
            'required' => trans('validation.required', ['attribute' => 'First Name']),
            'max' => [
                'string' => Lang::get('validation.max.string', ['attribute' => 'First Name', 'max' => 255]),
            ],
        ],
        'email' => [
            'email' => trans('validation.email', ['attribute' => 'Your Email']),
            'required' => trans('validation.required', ['attribute' => 'Your Email']),
            'min' => [
                'string' => Lang::get('validation.min.string', ['attribute' => 'Your Email', 'min' => 6]),
            ],
            'max' => [
                'string' => Lang::get('validation.max.string', ['attribute' => 'Your Email', 'max' => 50]),
            ],
        ],
    ],
    'page' => [
        'register' => [
            'title' => 'Register',
            'btn_submit_register' => 'Confirm',
        ],
        'login' => [
            'title' => 'Authorization',
            'btn_submit_login' => 'Login',
        ],
        'show'=> [
            'meta'=> [
                'title'=> ':name | Profile Page'
            ],
            'breadcrumb'=> 'Profile: :name',
            'posts_count'=> 'Published News',
            'comments_count'=> 'Comments'
        ],
    ],

    'meta'=> [
        'register'=> [
            'title'=> 'Register new user'
        ],
        'login'=> [
            'title'=> 'Authorization'
        ],
    ],

];
