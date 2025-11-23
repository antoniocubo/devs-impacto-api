<?php

namespace App\Infrastructure\Repositories\Post;

use App\Domain\Models\Post;
use Illuminate\Support\Collection;

class PostRepository
{
    public function __construct(
        private readonly Post $model
    ) {
    }

    public function create(array $data): Post
    {
        return $this->model::query()->create($data);
    }

    public function findByCategoryId(int $categoryId): Collection
    {
        return $this->model::query()
            ->where('category_id', $categoryId)
            ->get();
    }
}
