<?php

namespace App\Infrastructure\Services\Category;

use App\Domain\Dtos\Category\CategoryFollowDto;
use App\Domain\Dtos\Category\CategoryResponseDto;
use App\Domain\Dtos\Post\PostResponseDto;
use App\Domain\Models\User;
use App\Infrastructure\Repositories\Post\PostRepository;
use Illuminate\Support\Collection;

class CategoryFollowService
{
    public function __construct(
        private readonly PostRepository $postRepository,
    ) {
    }

    public function follow(User $user, CategoryFollowDto $dto)
    {
        $user->followedCategories()->syncWithoutDetaching($dto->categories);

        $categories = $this->loadUserCategories($user);

        return CategoryResponseDto::collect($categories);
    }

    public function postsFromFollowedCategories(User $user)
    {
        $categoryIds = $user->followedCategories()->pluck('categories.id');

        if ($categoryIds->isEmpty()) {
            return PostResponseDto::collect(collect());
        }

        $posts = $this->postRepository->findByCategoryIds($categoryIds->all());

        return PostResponseDto::collect($posts);
    }

    private function loadUserCategories(User $user): Collection
    {
        return $user->followedCategories()->get();
    }
}
