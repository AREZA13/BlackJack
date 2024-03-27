<?php

namespace App\Game\Poker;

use App\Game\Card;

class Player
{
    /**
     * @param Card[] $pocketCards
     */
    public function __construct(
        private array $pocketCards,
    )
    {
    }

}
