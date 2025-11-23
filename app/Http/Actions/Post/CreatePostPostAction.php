<?php

namespace App\Http\Actions\Post;

use App\Domain\Dtos\Post\PostCreateDto;
use App\Infrastructure\Services\Post\PostService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreatePostPostAction
{
    public function __construct(
        private readonly PostService $postService
    ) {
    }

    public function __invoke(PostCreateDto $postCreateDto): JsonResponse
    {
        $post = $this->postService->create($postCreateDto);

        return response()->json($post, Response::HTTP_CREATED);
    }
}
