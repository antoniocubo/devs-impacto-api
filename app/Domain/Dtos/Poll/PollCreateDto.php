<?php

namespace App\Domain\Dtos\Poll;

use Spatie\LaravelData\Data;

class PollCreateDto extends Data
{
    public function __construct(
        public string $title,
        public ?string $description,
    ) {
    }

    public static function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}
