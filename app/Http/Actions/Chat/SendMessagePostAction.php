<?php

namespace App\Http\Actions\Chat;

use App\Domain\Dtos\Chat\SendMessageDto;
use App\Domain\Dtos\Chat\SendMessageResponseDto;
use App\Infrastructure\Services\Chat\ChatService;

class SendMessagePostAction
{
    public function __construct(
        private ChatService $chatService
    ) {
    }

    public function __invoke(SendMessageDto $sendMessageDto)
    {
        $chatMessage = $this->chatService->sendMessage($sendMessageDto);

        return response()->json(SendMessageResponseDto::from($chatMessage));
    }
}
