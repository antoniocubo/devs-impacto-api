<?php

namespace App\Domain\Dtos\Chat;

use App\Domain\Models\Chat;
use Spatie\LaravelData\Data;

class ChatResponseDto extends Data
{
    public function __construct(
        public string $uuid,
        public int $userId
    ) {
    }

    public static function fromModel(Chat $chat): ChatResponseDto
    {
        return new self(
            uuid: $chat->uuid,
            userId: $chat->user_id
        );
    }
}
