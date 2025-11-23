<?php

namespace App\Infrastructure\Services\Chat;

use App\Domain\Dtos\Chat\SendMessageDto;
use App\Domain\Models\Chat;
use App\Domain\Models\ChatMessage;
use App\Infrastructure\Client\N8nClient;
use App\Infrastructure\Repositories\Chat\ChatMessageRepository;
use App\Infrastructure\Repositories\Chat\ChatRepository;

class ChatService
{
    public function __construct(
        private readonly ChatRepository $chatRepository,
        private readonly N8nClient $n8nClient,
        private readonly ChatMessageRepository $chatMessageRepository
    ) {
    }

    public function store(int $userId): Chat
    {
        $chat = new Chat([
            "user_id" => $userId
        ]);

        $this->chatRepository->save($chat);

        return $chat;
    }

    public function sendMessage(SendMessageDto $dto): string
    {
        $chat = $this->chatRepository->findBy(["uuid", $dto->chatUuid]);
        $n8nResponse = $this->n8nClient->post(config('n8n.chat_base_url'),[
            "message" => $dto->message,
            "session_id" => $dto->chatUuid,
        ]);

        $assistantChatMessage = new ChatMessage([
            "chat_id" => $chat->id,
            "content" => $n8nResponse[0]['output'],
            "role" => "assistant",
        ]);
        $userChatMessage = new ChatMessage([
            "chat_id" => $chat->id,
            "content" => $dto->message,
            "role" => "user",
        ]);

        $this->chatMessageRepository->saveMany([$userChatMessage, $assistantChatMessage]);

        return $assistantChatMessage;
    }
}
