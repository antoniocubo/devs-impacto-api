<?php

namespace App\Infrastructure\Services\Post;

use App\Domain\Dtos\Post\PostCreateDto;
use App\Domain\Dtos\Post\PostResponseDto;
use App\Infrastructure\Repositories\Post\PostRepository;

readonly class PostService
{
    public function __construct(
        private PostRepository $postRepository
    ) {
    }

    public function create(PostCreateDto $dto): PostResponseDto
    {
        $post = $this->postRepository->create([
            'title' => $dto->title,
            'content' => $dto->content,
            'audio_url' => $dto->audioUrl,
            'category_id' => $dto->categoryId,
        ]);

        return PostResponseDto::fromModel($post);
    }

    public function listByCategory(int $categoryId)
    {
        $posts = $this->postRepository->findByCategoryId($categoryId);

        return PostResponseDto::collect($posts);
    }
}
