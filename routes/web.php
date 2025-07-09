<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return ('Hello world');
});

Route::get('/latest-news', function () {
    return view('latest-news', [
        'newsItems' => [
            [
                'title'       => 'Article',
                'description' => 'Description of the article here',
                'date'        => date('F d, Y'),
                'author'      => 'John Doe',

            ],
            [
                'title'       => 'Article 2',
                'description' => 'This is another article!',
                'date'        => date('F d, Y'),
                'author'      => 'Joe Doe',

            ]
        ]
    ]);
});
