<?php

namespace App\Domain\Dtos\Post;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class PostCreateDto extends Data
{
    public function __construct(
        public string $title,
        public string $content,
        #[MapInputName('audio_url')]
        public string $audioUrl,
        #[MapInputName('category_id')]
        public int $categoryId,
    ) {
    }

    public static function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'audio_url' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }
}
