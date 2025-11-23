<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poll extends Model
{
    protected $fillable = [
        'title',
        'description',
        'votes_for',
        'votes_against',
    ];

    public function votes(): HasMany
    {
        return $this->hasMany(PollVote::class);
    }
}
