<?php

namespace App\Domain\Dtos\Post;

use App\Domain\Models\Post;
use Spatie\LaravelData\Data;

class PostResponseDto extends Data
{
    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        public string $audioUrl,
        public int $categoryId,
    ) {
    }

    public static function fromModel(Post $post): PostResponseDto
    {
        return new self(
            id: $post->id,
            title: $post->title,
            content: $post->content,
            audioUrl: $post->audio_url,
            categoryId: $post->category_id,
        );
    }
}
