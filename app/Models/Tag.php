<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Article;

/**
 * Class Tag
 */
class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    /**
     * Return the formatted bio content for use
     *
     * @return string|null
     */
    public function getFormattedBioAttribute(): string|null
    {
        if (empty($this->bio))
            return null;

        return html_entity_decode(strip_tags($this->bio));
    }

}
