<?php

use App\Http\Controllers\ArticleController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return ('Hello world');
});

Route::get('/latest-news', function () {


    $articles = Article::all();

    return view('latest-news', [
        'newsItems' => $articles
    ]);

});

Route::get('/latest-news/{newsItemId}', [ArticleController::class, 'show']);
