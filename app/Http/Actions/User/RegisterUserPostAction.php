<?php

namespace App\Http\Actions\User;

use App\Domain\Dtos\User\UserRegisterDto;
use App\Infrastructure\Services\User\UserService;
use Illuminate\Http\JsonResponse;

readonly class RegisterUserPostAction
{
    public function __construct(private UserService $service)
    {
    }

    public function __invoke(UserRegisterDto $userDto): JsonResponse
    {
        return response()->json($this->service->register($userDto->all()));
    }

}
