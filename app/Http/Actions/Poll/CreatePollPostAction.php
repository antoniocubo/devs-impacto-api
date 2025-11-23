<?php

namespace App\Http\Actions\Poll;

use App\Domain\Dtos\Poll\PollCreateDto;
use App\Infrastructure\Services\Poll\PollService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreatePollPostAction
{
    public function __construct(
        private readonly PollService $pollService,
    ) {
    }

    public function __invoke(PollCreateDto $pollCreateDto): JsonResponse
    {
        $poll = $this->pollService->create($pollCreateDto);

        return response()->json($poll, Response::HTTP_CREATED);
    }
}
