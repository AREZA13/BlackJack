<?php

namespace App\Game\Poker;

use App\Game\Deck;
use App\Game\Player;

class Poker
{
    /**
     * @param Player[] $players
     */
    public function __construct(
        public Deck  $deck,
        public array $players,
    )
    {
    }
}
