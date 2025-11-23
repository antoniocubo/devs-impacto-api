<?php

namespace App\Http\Actions\Articles;

use App\Domain\Dtos\Article\ArticleResponseDto;
use App\Domain\Dtos\Chat\ChatResponseDto;
use App\Infrastructure\Services\Article\ArticleService;
use Symfony\Component\HttpFoundation\JsonResponse;

class AllArticlesGetAction
{
    public function __construct(
        private readonly ArticleService $articleService
    ) {
    }

    public function __invoke(): JsonResponse
    {
        return response()->json(ArticleResponseDto::collect($this->articleService->getAll(request()->query('title'))));
    }
}
