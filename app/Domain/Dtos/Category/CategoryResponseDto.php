<?php

namespace App\Domain\Dtos\Category;

use App\Domain\Models\Category;
use Spatie\LaravelData\Data;

class CategoryResponseDto extends Data
{
    public function __construct(
        public int $id,
        public string $title,
    ) {
    }

    public static function fromModel(Category $category): self
    {
        return new self(
            id: $category->id,
            title: $category->title,
        );
    }
}
