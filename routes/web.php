<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TagController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return ('Hello world');
});

//news endpoints
Route::get('/latest-news', [ArticleController::class, 'index']);
Route::get('/latest-news/{articleId}', [ArticleController::class, 'show']);
Route::get('/articles/{articleId}', [ArticleController::class, 'show']);


//tags endpoints
Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/{tag}', [TagController::class, 'show'])->where('tag', '.*');

//tag - contributors
Route::get('/contributors', [TagController::class, 'contributors']);
Route::get('/contributors/{tag}', [TagController::class, 'contributor'])->where('tag', '.*');

//sections
Route::get('/sections', [SectionController::class, 'index']);
Route::get('/sections/{sectionId}', [SectionController::class, 'show']);
