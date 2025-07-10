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


    /*
    $sampleData = Storage::disk('public')->get('data.json');
    $data       = json_decode($sampleData, true);
    return view('latest-news', [
        'newsItems' => $data['response']['results']
    ]);*/

});

Route::get('/latest-news/{newsItemId}', function ($newsItemId) {
    $sampleData = Storage::disk('public')->get('data.json');
    $data       = json_decode($sampleData, true);

    $results = array_filter($data['response']['results'], function ($item) use ($newsItemId) {
        $webUrl   = $item['webUrl'];
        $path     = parse_url($webUrl, PHP_URL_PATH);
        $baseName = pathinfo($path, PATHINFO_FILENAME);

        return $baseName === $newsItemId;
    });

    $results = array_values($results);


    if(count($results) > 0 ){
        return view('components.articles.single', [
            'item'  => $results[0]
        ]);
    }else{
        return 'Not found';
    }

});
