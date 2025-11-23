<?php

namespace App\Domain\Dtos\Category;

use Spatie\LaravelData\Data;

class CategoryCreateDto extends Data
{
    public function __construct(
        public string $title,
    ) {
    }

    public static function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
        ];
    }
}
