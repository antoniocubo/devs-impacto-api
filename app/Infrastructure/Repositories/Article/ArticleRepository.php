<?php

namespace App\Infrastructure\Repositories\Article;

use App\Domain\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleRepository
{
    public function findAll(string $title): LengthAwarePaginator
    {
       return Article::query()
           ->where('title', 'LIKE', '%' . $title . '%')
           ->paginate(12);
    }
}
