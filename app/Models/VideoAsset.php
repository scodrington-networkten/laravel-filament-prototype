<?php

namespace App\Models;

use App\Models\Traits\HasGuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoAsset extends Model

{
    use HasGuid;

    protected $fillable = [
        'title',
        'description',
        'guid',
        'media_available_date',
        'media_expiration_date',
        'media_ratings',
        'pl_media_approved',
        'pl_media_chapters'
    ];

    protected $casts = [
        'media_ratings'     => 'array',
        'pl_media_chapters' => 'array'
    ];

    /** @use HasFactory<\Database\Factories\VideoAssetFactory> */
    use HasFactory;
}
