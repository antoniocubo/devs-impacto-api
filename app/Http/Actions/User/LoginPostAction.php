<?php

namespace App\Http\Actions\User;

use App\Domain\Dtos\User\UserLoginDto;
use App\Infrastructure\Services\User\UserService;
use Illuminate\Http\JsonResponse;

readonly class LoginPostAction
{

    public function __construct(private UserService $service)
    {
    }

    public function __invoke(UserLoginDto $dto): JsonResponse
    {
        return response()->json($this->service->login($dto->all()));
    }

}
