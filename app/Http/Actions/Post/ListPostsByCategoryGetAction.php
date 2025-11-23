<?php

namespace App\Http\Actions\Post;

use App\Infrastructure\Services\Post\PostService;
use Illuminate\Http\JsonResponse;

class ListPostsByCategoryGetAction
{
    public function __construct(
        private readonly PostService $postService,
    ) {
    }

    public function __invoke(int $categoryId): JsonResponse
    {
        $posts = $this->postService->listByCategory($categoryId);

        return response()->json($posts);
    }
}
