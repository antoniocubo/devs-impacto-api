<?php

namespace App\Http\Actions\Category;

use App\Infrastructure\Services\Category\CategoryFollowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ListFollowedCategoriesPostsGetAction
{
    public function __construct(
        private readonly CategoryFollowService $categoryFollowService,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user === null) {
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'Usuário não autenticado.');
        }

        $posts = $this->categoryFollowService->postsFromFollowedCategories($user);

        return response()->json($posts);
    }
}
