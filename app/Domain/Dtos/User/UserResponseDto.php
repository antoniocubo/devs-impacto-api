<?php

namespace App\Domain\Dtos\User;


use App\Domain\Models\User;
use Spatie\LaravelData\Data;

class UserResponseDto extends Data
{

    public function __construct(
        public int $id,
        public string $name,
        public string $email,
    ) {
    }

    public function fromModel(User $user): UserResponseDto
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email
        );
    }

}
