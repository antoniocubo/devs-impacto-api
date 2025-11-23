<?php

namespace App\Domain\Dtos\Chat;

use Spatie\LaravelData\Data;

class SendMessageResponseDto extends Data
{
    public function __construct(
        public int $id,
        public string $role,
        public string $content,
    ) {
    }
}
