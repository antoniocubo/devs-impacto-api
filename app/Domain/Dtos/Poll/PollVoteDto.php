<?php

namespace App\Domain\Dtos\Poll;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class PollVoteDto extends Data
{
    public function __construct(
        #[MapInputName('is_in_favor')]
        public bool $isInFavor,
    ) {
    }

    public static function rules(): array
    {
        return [
            'is_in_favor' => ['required', 'boolean'],
        ];
    }
}
