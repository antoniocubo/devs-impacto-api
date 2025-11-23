<?php

namespace App\Http\Actions\Poll;

use App\Infrastructure\Services\Poll\PollService;
use Illuminate\Http\JsonResponse;

class ListPollsGetAction
{
    public function __construct(
        private readonly PollService $pollService,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $polls = $this->pollService->list();

        return response()->json($polls);
    }
}
