<?php

namespace App\Infrastructure\Repositories\User;

use App\Domain\Models\User;

readonly class UserRepository
{

    public function __construct(private User $model)
    {
    }

    public function create(array $data): User
    {
        return $this->model::query()->create($data);
    }


}
