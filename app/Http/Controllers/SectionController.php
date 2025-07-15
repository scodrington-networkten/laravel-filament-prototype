<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Section;
use App\Models\Tag;
use Illuminate\View\View;

class SectionController extends Controller
{
    public function index(): View
    {
        $sections = Section::with('tags')->get();
        return view('components.sections.index', [
            'sections' => $sections
        ]);
    }

    public function show(string $sectionId): View
    {
        $section  = Section::where('uid', $sectionId)->firstOrFail();
        $articles = Article::where('section_id', $sectionId)->get();
        $tags = Tag::where('section_id', $sectionId)->get();

        return view('components.sections.single', [
            'section'  => $section,
            'articles' => $articles,
            'tags'     => $tags
        ]);
    }
}
