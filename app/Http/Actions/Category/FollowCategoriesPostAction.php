<?php

namespace App\Http\Actions\Category;

use App\Domain\Dtos\Category\CategoryFollowDto;
use App\Infrastructure\Services\Category\CategoryFollowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FollowCategoriesPostAction
{
    public function __construct(
        private readonly CategoryFollowService $categoryFollowService,
    ) {
    }

    public function __invoke(CategoryFollowDto $categoryFollowDto, Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user === null) {
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'Usuário não autenticado.');
        }

        $categories = $this->categoryFollowService->follow($user, $categoryFollowDto);

        return response()->json($categories);
    }
}
