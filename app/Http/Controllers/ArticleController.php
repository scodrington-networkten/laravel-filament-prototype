<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function show($articleUrl): View
    {
        $articles = Article::with('media')->get();
        $article  = $articles->first(function ($article) use ($articleUrl) {
            $urlPath     = parse_url($article->publication_url, PHP_URL_PATH);
            $lastSegment = basename($urlPath);

            return $lastSegment === $articleUrl;
        });

        if ($article) {
            $article->getMainImages();
            return view('components.articles.single', [
                'article' => $article
            ]);
        } else {
            return 'Not found';
        }
    }

    public function index(): View
    {
        $articles = Article::all();
        return view('latest-news', [
            'newsItems' => $articles
        ]);
    }
}
