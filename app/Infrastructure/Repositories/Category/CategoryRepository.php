<?php

namespace App\Infrastructure\Repositories\Category;

use App\Domain\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository
{
    public function __construct(
        private readonly Category $model,
    ) {
    }

    public function create(array $data): Category
    {
        return $this->model::query()->create($data);
    }

    public function all(): Collection
    {
        return $this->model::query()->get();
    }
}
