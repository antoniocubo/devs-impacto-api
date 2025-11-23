<?php

namespace App\Infrastructure\Repositories\Chat;

class ChatMessageRepository
{
    public function saveMany(array $chatMessages): void
    {
        foreach ($chatMessages as $chatMessage) {
            $chatMessage->save();
        }
    }
}
