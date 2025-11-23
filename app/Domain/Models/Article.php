<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        "title",
        "content",
        "audio_url"
    ];
}
