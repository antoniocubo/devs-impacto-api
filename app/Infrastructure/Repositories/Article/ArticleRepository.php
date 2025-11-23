<?php

namespace App\Infrastructure\Repositories\Article;

use App\Domain\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleRepository
{
    public function findAll(): LengthAwarePaginator
    {
       return Article::query()->paginate(12);
    }
}
