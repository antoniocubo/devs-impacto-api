<?php

namespace App\Infrastructure\Repositories\Poll;

use App\Domain\Models\Poll;
use Illuminate\Support\Collection;

class PollRepository
{
    public function __construct(
        private readonly Poll $model,
    ) {
    }

    public function create(array $data): Poll
    {
        return $this->model::query()->create($data);
    }

    public function findById(int $id): Poll
    {
        return $this->model::query()->findOrFail($id);
    }

    public function incrementVote(Poll $poll, bool $inFavor): Poll
    {
        $column = $inFavor ? 'votes_for' : 'votes_against';

        $poll->increment($column);

        return $poll->refresh();
    }

    public function all(): Collection
    {
        return $this->model::query()
            ->latest()
            ->get();
    }
}
