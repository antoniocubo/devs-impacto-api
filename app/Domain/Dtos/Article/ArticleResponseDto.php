<?php

namespace App\Domain\Dtos\Article;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class ArticleResponseDto extends Data
{
    public function __construct(
        public string $title,
        public ?string $audio_url,
        public string $content
    ) {
    }
}
