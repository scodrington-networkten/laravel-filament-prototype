<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->media()->firstWhere('relation', 'thumbnail');
    }

    public function hasThumbnailImage(): bool{
        return $this->getThumbnailImage() !== null;
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

    /**
     * Given a media item, return the HTML img tag using it's info
     *
     * @param $mediaItem media item
     *
     * @return string
     */
    public function getImageForMediaItem($mediaItem): string
    {
        $metadata = json_decode($mediaItem->metadata, true);
        return "<img
            width='{$metadata['width']}'
            height='{$metadata['height']}'
            src='{$mediaItem['url']}'
            alt='$mediaItem->alt_text'
            title='$mediaItem->title'/>";
    }

}
