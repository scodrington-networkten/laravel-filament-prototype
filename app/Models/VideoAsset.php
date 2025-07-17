<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoAsset extends Model
{

    protected $fillable = [
        'title',
        'description',
        'guid',
        //'mediaAvailableDate',
        //'mediaExpirationDate',
    ];

    protected $casts = [
        'mediaRatings' => 'array',
    ];

    /** @use HasFactory<\Database\Factories\VideoAssetFactory> */
    use HasFactory;
}
