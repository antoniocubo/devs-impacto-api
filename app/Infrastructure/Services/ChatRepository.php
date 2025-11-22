<?php

namespace App\Infrastructure\Services;

use App\Domain\Models\Chat;

class ChatRepository
{
    public function save(Chat $chat): void
    {
        $chat->save();
    }
}
