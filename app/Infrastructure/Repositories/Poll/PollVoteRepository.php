<?php

namespace App\Infrastructure\Repositories\Poll;

use App\Domain\Models\PollVote;

class PollVoteRepository
{
    public function __construct(
        private readonly PollVote $model,
    ) {
    }

    public function create(array $data): PollVote
    {
        return $this->model::query()->create($data);
    }

    public function hasUserVoted(int $pollId, int $userId): bool
    {
        return $this->model::query()
            ->where('poll_id', $pollId)
            ->where('user_id', $userId)
            ->exists();
    }
}
