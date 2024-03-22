<?php

namespace App\Game;

readonly class Card
{
    public function __construct(
        public string $suit,
        public string $nominal,
    )
    {
    }
}
