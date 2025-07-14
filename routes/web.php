<?php

use App\Http\Controllers\ArticleController;
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
Route::get('/latest-news/{newsItemId}', [ArticleController::class, 'show']);

Route::get('/sections', [TagController::class, 'indexSection']);
