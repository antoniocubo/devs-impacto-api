<?php

namespace App\Http\Actions\Poll;

use App\Domain\Dtos\Poll\PollVoteDto;
use App\Infrastructure\Services\Poll\PollService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VotePollPostAction
{
    public function __construct(
        private readonly PollService $pollService,
    ) {
    }

    public function __invoke(int $pollId, PollVoteDto $pollVoteDto, Request $request): JsonResponse
    {
        $userId = $request->user()?->id;

        if ($userId === null) {
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'Usuário não autenticado.');
        }

        $poll = $this->pollService->vote($pollId, $userId, $pollVoteDto);

        return response()->json($poll);
    }
}
