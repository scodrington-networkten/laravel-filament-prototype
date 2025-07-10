<?php

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

Route::get('/latest-news/{newsItemId}', function ($newsItemId) {


    $articles = Article::all();
    $article = $articles->first(function ($article) use ($newsItemId) {

        $urlPath = parse_url($article->publication_url, PHP_URL_PATH);
        $lastSegment = basename($urlPath);

        return $lastSegment === $newsItemId;

    });


    if($article){
        return view('components.articles.single', [
            'article'  => $article
        ]);
    }else{
        return 'Not found';
    }



});
