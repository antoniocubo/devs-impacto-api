<?php

namespace App\Infrastructure\Services\User;

use App\Domain\Dtos\User\UserResponseDto;
use App\Enums\ApiStatus;
use App\Infrastructure\Repositories\User\UserRepository;
use App\Models\User;
use App\Utils\OperationResult;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

readonly class UserService
{

    public function __construct(private UserRepository $repository)
    {
    }

    public function login(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            throw new AuthenticationException('Credenciais inválidas.');
        }
        return [
            'token' => Auth::user()->createToken('auth_token')->plainTextToken,
            'tokenType' => 'Bearer',
        ];
    }


    public function register(array $data): UserResponseDto
    {
        return UserResponseDto::from($this->repository->create($data));
    }

}
