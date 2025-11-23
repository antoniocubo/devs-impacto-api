<?php

namespace App\Infrastructure\Services\Category;

use App\Domain\Dtos\Category\CategoryCreateDto;
use App\Domain\Dtos\Category\CategoryResponseDto;
use App\Infrastructure\Repositories\Category\CategoryRepository;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
    ) {
    }

    public function create(CategoryCreateDto $dto): CategoryResponseDto
    {
        $category = $this->categoryRepository->create([
            'title' => $dto->title,
        ]);

        return CategoryResponseDto::fromModel($category);
    }

    public function list()
    {
        $categories = $this->categoryRepository->all();

        return CategoryResponseDto::collect($categories);
    }
}
