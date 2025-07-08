<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function(){
    return ('Hello world');
});

Route::get('/latest-news', function() {
    return view('latest-news');
});
