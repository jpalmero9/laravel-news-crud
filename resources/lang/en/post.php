<?php

return [
    'box' => [
        'popular' => [
            'title' => 'News'
        ],
        'latest' => [
            'title' => 'News'
        ],
    ],
    'meta' => [
        'title' => 'All news | NewsCrud',
        'title_category' => ':category | NewsCrud',
    ],
    'page' => [
        'index' => [
            'title' => 'All news ',
            'btn_post_create' => 'Add News',
            'btn_post_edit' => 'Edit',
            'btn_post_delete' => 'Delete',
            'tag_title' => 'Tag'
        ],
        'edit' => [
            'title' => 'Edit News',
            'created_at' => 'Created',
            'updated_at' => 'Edited',
            'btn_submit_edit' => 'Confirm',
            'message_edit_success' => 'News success edited',
        ],
        'create' => [
            'title' => 'Add news',
            'btn_submit_create' => 'Add',
            'message_edit_success' => 'News success created',
        ],
    ],
    'modal_confirm_delete' => [
        'title' => 'Delete this post?',
        'btn_delete' => 'Confirm',
        'btn_close' => 'Close',
    ],
    'result_is_empty' => 'News is not found',
    'option_select' => '- Select -',
    'manage_form' => [
        'published_at' => 'Publish',
        'published_now' => 'Publish Now',
        'category_id' => 'Category',
        'slug' => 'Slug',
        'tags' => 'Tags',

        'title' => 'Meta Title',
        'description' => 'Meta Description',
        'keywords' => 'Meta Keywords',
        'name' => 'Heading',
        'summary' => 'Summary',
        'story' => 'Story',
    ],
    'article' => [
        'category' => 'Category',
        'author' => 'Author',
    ],
    'validate_messages' => [
        'index' => [
            'page' => [
                'integer' => trans('validation.integer', ['attribute' => 'Page number']),
            ],
            'limit' => [
                'integer' => trans('validation.integer', ['attribute' => 'Limit']),
                'max' => [
                    'integer' => trans('validation.max.integer', ['attribute' => 'Limit', 'max' => 100]),
                ],
            ],
            'category_id' => [
                'integer' => trans('validation.integer', ['attribute' => 'Category ID']),
                'exists' => trans('validation.exists', ['attribute' => 'Category ID']),
            ],
            'author_id' => [
                'integer' => trans('validation.integer', ['attribute' => 'Author ID']),
                'exists' => trans('validation.exists', ['attribute' => 'Author ID']),
            ],
            'tag' => [
                'string' => trans('validation.integer', ['attribute' => 'Tag']),
                'between' => [
                    'string' => trans('validation.between.string', ['attribute' => 'Tag', 'min' => 3, 'max' => 20])
                ],
            ],
        ],
        'create' => [
            'user_id' => [
                'required' => trans('validation.required', ['attribute' => 'User ID']),
                'integer' => trans('validation.integer', ['attribute' => 'User ID']),
            ],
            'published_at' => [
                'date_format' => trans('validation.date_format',
                    ['attribute' => 'Publish', 'format' => 'YYYY-MM-DD h:m:s']),
            ],
            'published_now' => [
                'boolean' => trans('validation.boolean', ['attribute' => 'Publish Now']),
            ],
            'category_id' => [
                'required' => trans('validation.required', ['attribute' => 'Category']),
                'integer' => trans('validation.integer', ['attribute' => 'Category']),
            ],
            'slug' => [
                'string' => trans('validation.string', ['attribute' => 'Slug']),
                'max' => [
                    'string' => trans('validation.max.string', ['attribute' => 'Slug', 'max' => 70]),
                ],
            ],

            'tags.*' => [
                'string' => trans('validation.string', ['attribute' => 'Tags']),
                'max' => [
                    'string' => trans('validation.max.string', ['attribute' => 'Tags', 'max' => 20]),
                ],
            ],

            'title' => [
                'string' => trans('validation.string', ['attribute' => 'Meta Title']),
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => 'Meta Title', 'max' => 55]),
                ],
            ],
            'description' => [
                'string' => trans('validation.string', ['attribute' => 'Meta Description']),
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => 'Meta Description', 'max' => 155]),
                ],
            ],
            'keywords' => [
                'string' => trans('validation.string', ['attribute' => 'Meta Keywords']),
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => 'Meta Keywords', 'max' => 250]),
                ],
            ],
            'name' => [
                'required' => trans('validation.required', ['attribute' => 'Heading']),
                'string' => trans('validation.string', ['attribute' => 'Heading']),
                'min' => [
                    'string' => trans('validation.min.string', ['attribute' => 'Heading', 'min' => 3]),
                ],
                'max' => [
                    'string' => trans('validation.max.string', ['attribute' => 'Heading', 'max' => 255]),
                ],
            ],
            'summary' => [
                'required' => trans('validation.required', ['attribute' => 'Summary']),
                'string' => trans('validation.string', ['attribute' => 'Summary']),
                'min' => [
                    'string' => trans('validation.min.string', ['attribute' => 'Summary', 'min' => 3]),
                ],
                'max' => [
                    'string' => trans('validation.max.string', ['attribute' => 'Summary', 'max' => 1000]),
                ],
            ],
            'story' => [
                'string' => trans('validation.string', ['attribute' => 'Story']),
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => 'Story', 'max' => 5000]),
                ],
            ],

        ],

        'update' => [
            'id' => [
                'required' => trans('validation.required', ['attribute' => 'News ID']),
                'integer' => trans('validation.integer', ['attribute' => 'News ID']),
            ],
        ],
    ],
    'comments_loop' => [
        'validate_messages' => [
            'index' => [
                'page' => [
                    'integer' => trans('validation.integer', ['attribute' => 'Comment page number']),
                ],
            ],
        ],
    ],
];
