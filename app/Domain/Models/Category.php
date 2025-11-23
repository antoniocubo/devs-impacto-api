<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'title',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
