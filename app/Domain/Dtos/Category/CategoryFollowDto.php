<?php

namespace App\Domain\Dtos\Category;

use Spatie\LaravelData\Data;

class CategoryFollowDto extends Data
{
    public function __construct(
        public array $categories,
    ) {
    }

    public static function rules(): array
    {
        return [
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['integer', 'exists:categories,id'],
        ];
    }
}
