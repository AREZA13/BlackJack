<?php

namespace App\Game\Poker\PlayerHand\Combinations;

use App\Game\Poker\CompareHandResultEnum;
use App\Game\Poker\PlayerHand\AbstractPlayerHand;

class OnePairPlayerHand extends AbstractPlayerHand
{
    public function __construct(
        private readonly array $pair,
        private readonly array $threeCards,
        int                    $playerId,
    )
    {
        parent::__construct(
            array_merge($pair, $threeCards),
            $playerId
        );
    }

    public function getPair(): array
    {
        return $this->pair;
    }

    public function getThreeCards(): array
    {
        return $this->threeCards;
    }

    public function compare(AbstractPlayerHand $otherHand): CompareHandResultEnum
    {
        if ($otherHand instanceof self) {
            return CompareHandResultEnum::Equal;
        }
        if ($otherHand instanceof HighCardPlayerHand) {
            return CompareHandResultEnum::Higher;
        }

        return CompareHandResultEnum::Lower;
    }
}
