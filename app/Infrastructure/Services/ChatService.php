<?php

namespace App\Infrastructure\Services;

use App\Domain\Models\Chat;

class ChatService
{
    public function __construct(
        private readonly ChatRepository $chatRepository
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
}
