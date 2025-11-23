<?php

namespace App\Domain\Dtos\Poll;

use App\Domain\Models\Poll;
use Spatie\LaravelData\Data;

class PollResponseDto extends Data
{
    public function __construct(
        public int $id,
        public string $title,
        public ?string $description,
        public int $votesFor,
        public int $votesAgainst,
    ) {
    }

    public static function fromModel(Poll $poll): self
    {
        return new self(
            id: $poll->id,
            title: $poll->title,
            description: $poll->description,
            votesFor: $poll->votes_for,
            votesAgainst: $poll->votes_against,
        );
    }
}
