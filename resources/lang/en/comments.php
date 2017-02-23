<?php

return [
    'box' => [
        'latest' => [
            'title' => 'Discuss'
        ],
    ],
    'post_show' => [
        'title' => 'Comments',
    ],
    'form_add' => [
        'title' => 'Add Comment',
        'btn_submit_add' => 'Save',
        'inputs' => [
            'name' => 'Your First Name',
            'email' => 'Your Email',
            'content' => 'Comment',
        ],
    ],
    'index'=>[
        'title_all'=> 'All Comments',
        'title_name'=> ':name Comments',
    ],
    'result_is_empty'=> 'Not found any comments',
    'validate_messages' => [
        'add' => [
            'post_id' => [
                'required' => trans('validation.required', ['attribute' => 'ID news']),
                'integer' => trans('validation.integer', ['attribute' => 'ID news']),
            ],
            'user_id' => [
                'required_without_all' => trans('validation.required_without_all',
                    ['attribute' => 'user ID', 'values' => 'First Name and Email']),
                'integer' => trans('validation.integer', ['attribute' => 'user ID']),
                'exists' => trans('validation.exists', ['attribute' => 'user ID']),
            ],
            'name' => [
                'string' => trans('validation.string', ['attribute' => 'Ваше Имя']),
                'required_without' => trans('validation.required_without',
                    ['attribute' => 'First Name', 'values' => 'user ID']),
                'required_with' => trans('validation.required_with',
                    ['attribute' => 'First Name', 'values' => 'Your Email']),
                'min' => [
                    'string' => trans('validation.min.string', ['attribute' => 'First Name', 'min' => 3]),
                ],
                'max' => [
                    'string' => trans('validation.max.string', ['attribute' => 'First Name', 'max' => 50]),
                ],
            ],
            'email' => [
                'required_without' => trans('validation.required_without',
                    ['attribute' => 'Your Email', 'values' => 'user ID']),
                'required_with' => trans('validation.required_with',
                    ['attribute' => 'Your Email', 'values' => 'First Name']),
                'email' => trans('validation.email', ['attribute' => 'Your Email']),
                'min' => [
                    'string' => trans('validation.min.string', ['attribute' => 'Your Email', 'min' => 6]),
                ],
                'max' => [
                    'string' => trans('validation.max.string', ['attribute' => 'Your Email', 'max' => 50]),
                ],
            ],
            'content' => [
                'required' => trans('validation.required', ['attribute' => 'Comment']),
                'string' => trans('validation.string', ['attribute' => 'Comment']),
                'min' => [
                    'string' => trans('validation.min.string', ['attribute' => 'Comment', 'min' => 3]),
                ],
                'max' => [
                    'string' => trans('validation.max.string', ['attribute' => 'Comment', 'max' => 500]),
                ],
            ],
        ],

        'latest' => [
            'limit' => [
                'required' => trans('validation.required', ['attribute' => 'Limit']),
                'integer' => trans('validation.integer', ['attribute' => 'Limit']),
            ],
        ],

        'index'=> [
            'page' => [
                'integer' => trans('validation.integer', ['attribute' => 'Page number']),
            ],
            'limit' => [
                'integer' => trans('validation.integer', ['attribute' => 'Limit']),
                'max' => [
                    'integer' => trans('validation.max.integer', ['attribute' => 'Limit', 'max' => 100]),
                ],
            ],
            'post_id' => [
                'integer' => trans('validation.integer', ['attribute' => 'News ID']),
                'exists' => trans('validation.exists', ['attribute' => 'News ID']),
            ],
            'author_id' => [
                'integer' => trans('validation.integer', ['attribute' => 'Author ID']),
                'exists' => trans('validation.exists', ['attribute' => 'Author ID']),
            ],
        ],

    ],
];
