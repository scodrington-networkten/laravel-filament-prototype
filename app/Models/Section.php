<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $fillable = [
        'uid',
        'web_title',
        'web_url',
        'editions'
    ];

    protected $casts = [
        'editions' => 'array'
    ];

    /** @use HasFactory<\Database\Factories\SectionFactory> */
    use HasFactory;

    public function tags() : HasMany{
        return $this->hasMany(Tag::class, 'section_id', 'uid');
    }
}
