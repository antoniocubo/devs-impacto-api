<?php

namespace App\Domain\Dtos\Chat;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class SendMessageDto extends Data
{
    public function __construct(
        #[MapInputName('chat_uuid')]
        public string $chatUuid,
        public string $message,
    ) {}
    public static function rules():  array
    {
        return [
            'chat_uuid' => ['required', 'string', 'exists:chats,uuid'],
            'message' => ['required', 'string'],
        ];
    }
}
