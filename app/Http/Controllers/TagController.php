<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\View\View;

class TagController extends Controller
{
    /**
     * Return a page showing all keyword tags that have a section_id which are top level keywords
     *
     * @return View
     */
    public function indexSection()
    {
        $sectionTags = Tag::where('type', 'keyword')->where('section_id', '!=', null)->get();

        return view('components.tags.sections', [
            'tags' => $sectionTags
        ]);
    }

    /**
     * Show a single tag, without route binding, we need to manually find the tag
     *
     * @param string $tagUid
     *
     * @return View
     */
    public function show(string $tagUid): View
    {
        $tag      = Tag::where('uid', $tagUid)->first();
        $articles = $tag->articles()->get();

        return view('components.tags.single', [
            'tag'      => $tag,
            'articles' => $articles
        ]);
    }
}
