<?php

namespace App\Game\Poker\PlayerHand;

use App\Game\Card;
use App\Game\Poker\CompareHandResultEnum;

abstract class AbstractPlayerHand
{
    /**
     * @param array{0: Card, 1: Card, 2: Card, 3: Card, 4: Card} $cards
     */
    public function __construct(
        protected array     $cards,
        public readonly int $playerId,
    )
    {
    }

    /**
     * @return Card[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }


    abstract public function compare(AbstractPlayerHand $otherHand): CompareHandResultEnum;
    /**
     * @param array{0: Card, 1: Card, 2: Card, 3: Card, 4: Card, 5: Card, 6: Card} $arrayOfSevenCards
     */
}
