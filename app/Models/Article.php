<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'type',
        'title',
        'subtitle',
        'body',
        'last_modified_date',
        'published_date',
        'publication',
        'publication_url',
        'byline',
        'pillar',
    ];
}
