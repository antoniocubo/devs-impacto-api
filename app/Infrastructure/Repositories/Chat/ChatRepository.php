<?php

namespace App\Infrastructure\Repositories\Chat;

use App\Domain\Models\Chat;

class ChatRepository
{
    public function save(Chat $chat): void
    {
        $chat->save();
    }

    public function findBy(array ...$criteria): ?Chat
    {
        return Chat::where($criteria)->first();
    }
}
