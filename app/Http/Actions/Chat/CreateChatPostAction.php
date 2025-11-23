<?php

namespace App\Http\Actions\Chat;

use App\Domain\Dtos\Chat\ChatResponseDto;
use App\Infrastructure\Services\Chat\ChatService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateChatPostAction
{
    public function __construct(
        private readonly ChatService $chatService
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $chat = $this->chatService->store(auth()->id());

        return response()->json(ChatResponseDto::fromModel($chat), Response::HTTP_CREATED);
    }
}
