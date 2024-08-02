<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class GameGto
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $result,

        #[Assert\NotBlank]
        public readonly string $date,

        #[Assert\NotBlank]
        public readonly string $players,

        #[Assert\NotBlank]
        #[Assert\Length(min: 10, max: 500)]
        public readonly string $duration,
    ) {
    }
}
