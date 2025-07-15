<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Media
 */
class Media extends Model
{
    protected $fillable = [
        'relation',
        'type',
        'mime_type',
        'url',
        'metadata'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Create a virtual attribite 'metadata_array' which is the JSON decoded value from `metadata` column
     *
     * @return Attribute
     */
    protected function metadataArray(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $this->metadata_array = json_decode($attributes['metadata'], true)
        );
    }

    public function width(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->metadata_array['width'] ?? null
        );
    }

    public function height(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->metadata_array['height'] ?? null
        );
    }

    public function altText(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->metadata_array['alt_text'] ?? null
        );
    }

    public function caption(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->metadata_array['caption'] ?? null
        );
    }
}
