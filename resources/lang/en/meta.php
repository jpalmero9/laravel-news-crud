<?php

return [
    'prefix' => 'og: http://ogp.me/ns#',
    'charset' => 'utf-8',
    'title' => 'The NewsCrud System',
    'description' => 'Description for NewsCrud',
    'keywords' => 'news, comments, tags, crud',
    'images' => [
        [
            'url' => config('app.url') . '/vendor/news-crud/img/meta/android-chrome-192x192.png',
            'width' => 192,
            'height' => 192,
            'type' => 'image/png'
        ],
    ],
];
