<?php

return [
    'index' => [
        'title' => 'Categories List',
        'btn_category_create' => 'Create Category',
        'btn_category_edit' => 'Edit',
        'btn_category_delete' => 'Delete',
        'table_columns' => [
            'name' => 'Name',
            'slug' => 'Slug',
            'active' => 'Active',
        ],
        'active_status_yes' => 'YES',
        'active_status_no' => 'NO',
    ],
    'create' => [
        'title' => 'Create Category',
        'btn_submit_create' => 'Add',
    ],
    'edit' => [
        'title' => 'Edit Category',
        'btn_submit_edit' => 'Confirm',
        'message_edit_success' => 'Category success created'
    ],
    'manage_form' => [
        'slug' => 'Slug',
        'name' => 'Name',
        'active' => 'Activate',
    ],

    'validate_messages' => [
        'create' => [
            'active' => [
                'boolean' => trans('validation.boolean', ['attribute' => 'Activate']),
            ],
            'slug' => [
                'string' => trans('validation.string', ['attribute' => 'Slug']),
                'max' => [
                    'string' => trans('validation.max.string', ['attribute' => 'Slug', 'max' => 70]),
                ],
            ],
            'name' => [
                'required' => trans('validation.required', ['attribute' => 'Name']),
                'string' => trans('validation.string', ['attribute' => 'Name']),
                'min' => [
                    'string' => trans('validation.min.string', ['attribute' => 'Name', 'min' => 3]),
                ],
                'max' => [
                    'string' => trans('validation.max.string', ['attribute' => 'Name', 'max' => 100]),
                ],
            ],
        ],
        'update' => [
            'id' => [
                'required' => trans('validation.required', ['attribute' => 'ID category']),
                'integer' => trans('validation.integer', ['attribute' => 'ID category']),
            ],
        ],
    ],
];