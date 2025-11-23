<?php

namespace App\Domain\Dtos\User;


use App\Domain\Models\User;
use Spatie\LaravelData\Data;

class UserRegisterDto extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:250'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
