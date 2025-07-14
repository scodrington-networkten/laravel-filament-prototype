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
}
