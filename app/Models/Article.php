<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Tag;

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

    public function tags() : BelongsToMany{
        return $this->belongsToMany(Tag::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Returns a singular associated media item to be used as the thumbnail
     *
     * @return array|null
     */
    public function getThumbnailImage(): Media|null
    {
        return $this->media->firstWhere('relation', 'thumbnail');
    }

    /**
     * returns if an article thumbnail exists
     *
     * @return bool
     */
    public function hasThumbnailImage(): bool
    {
        return $this->getThumbnailImage() !== null;
    }

    /**
     * Given a media item, return the HTML img tag using its info
     *
     * @param Media $mediaItem
     *
     * @return string
     */
    public function getImageForMediaItem(Media $mediaItem): string
    {
        return "<img
            width='{$mediaItem->width}'
            height='{$mediaItem->height}'
            alt='{$mediaItem->altText}'
            src='{$mediaItem->url}'
            title='{$mediaItem->title}'/>";
    }

    /**
     * Returns an array of associated media items for the article, sorted by largest image first
     *
     * @return array|null
     */
    public function getMainImages(): Collection|null
    {
        if (empty($this->media))
            return null;

        $mainImages = $this->media->where('relation', 'main')->sortByDesc(function ($media) {
            $metaData = json_decode($media->metadata, true);
            return $metaData['width'] ?? 0;
        });

        return $mainImages;
    }

}
