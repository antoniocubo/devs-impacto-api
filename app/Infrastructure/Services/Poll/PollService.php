<?php

namespace App\Infrastructure\Services\Poll;

use App\Domain\Dtos\Poll\PollCreateDto;
use App\Domain\Dtos\Poll\PollResponseDto;
use App\Domain\Dtos\Poll\PollVoteDto;
use App\Infrastructure\Repositories\Poll\PollRepository;
use App\Infrastructure\Repositories\Poll\PollVoteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PollService
{
    public function __construct(
        private readonly PollRepository $pollRepository,
        private readonly PollVoteRepository $pollVoteRepository,
    ) {
    }

    public function create(PollCreateDto $dto): PollResponseDto
    {
        $poll = $this->pollRepository->create([
            'title' => $dto->title,
            'description' => $dto->description,
        ]);

        return PollResponseDto::fromModel($poll);
    }

    public function list()
    {
        $polls = $this->pollRepository->all();

        return PollResponseDto::collect($polls);
    }

    public function vote(int $pollId, int $userId, PollVoteDto $dto): PollResponseDto
    {
        if ($this->pollVoteRepository->hasUserVoted($pollId, $userId)) {
            throw new HttpException(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                'Você já votou nesta enquete.'
            );
        }

        $poll = $this->pollRepository->findById($pollId);

        $this->pollVoteRepository->create([
            'poll_id' => $poll->id,
            'user_id' => $userId,
            'is_in_favor' => $dto->isInFavor,
        ]);

        $poll = $this->pollRepository->incrementVote($poll, $dto->isInFavor);

        return PollResponseDto::fromModel($poll);
    }
}
