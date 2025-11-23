<?php

namespace App\Http\Actions\Category;

use App\Domain\Dtos\Category\CategoryCreateDto;
use App\Infrastructure\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateCategoryPostAction
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    public function __invoke(CategoryCreateDto $categoryCreateDto): JsonResponse
    {
        $category = $this->categoryService->create($categoryCreateDto);

        return response()->json($category, Response::HTTP_CREATED);
    }
}
