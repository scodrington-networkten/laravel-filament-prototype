<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    protected $fillable = [
        'relation',
        'type',
        'mime_type',
        'url',
        'metadata'
    ];

    public function article() : BelongsTo{
        return $this->belongsTo(Article::class);
    }
}
