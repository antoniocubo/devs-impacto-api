<?php

namespace App\Http\Actions\Category;

use App\Infrastructure\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;

class ListCategoriesGetAction
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $categories = $this->categoryService->list();

        return response()->json($categories);
    }
}
