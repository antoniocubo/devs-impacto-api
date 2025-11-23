<?php

namespace App\Infrastructure\Services\Article;

use App\Infrastructure\Repositories\Article\ArticleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ArticleService
{
    public function __construct(
        private readonly ArticleRepository $articleRepository
    ) {
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->articleRepository->findAll();
    }
}
