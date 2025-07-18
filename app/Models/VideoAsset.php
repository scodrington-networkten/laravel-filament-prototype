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
        'media_available_date',
        'media_expiration_date',
        'guid',

        'pl_media_approved',

        'tv_channel',
        'tv_episode',
        'tv_season',
        'tv_show',
        'tv_show_group',
        'tv_week',

        'broadcast_date_previous',
        'production_company',
        'production_country',
        'program_classification',
        'program_language',
        'restriction_by_member',
        'clip_category',
        'consumer_advice',
        'content_security',
        'dmi_show_id',
        'series_crid',
        'shoppable_enabled',
        'video_format_type',
        'pl_media_pid',

        'media_ratings',
        'pl_media_chapters',
        'video_segments',
    ];

    protected $casts = [
        'media_ratings'     => 'array',
        'pl_media_chapters' => 'array',
        'video_segments'    => 'array',

        'media_available_date'    => 'integer',
        'media_expiration_date'   => 'integer',
        'broadcast_date_previous' => 'integer',

        'pl_media_approved'     => 'boolean',
        'restriction_by_member' => 'boolean',
        'shoppable_enabled'     => 'boolean',

        'tv_week'      => 'integer',
        'dmi_show_id'  => 'integer',
        'series_crid'  => 'integer',
        'pl_media_pid' => 'integer',
    ];

    /** @use HasFactory<\Database\Factories\VideoAssetFactory> */
    use HasFactory;
}
