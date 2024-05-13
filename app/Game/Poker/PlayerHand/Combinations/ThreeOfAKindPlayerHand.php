<?php

namespace App\Game\Poker\PlayerHand\Combinations;

use App\Game\Poker\CompareHandResultEnum;
use App\Game\Poker\PlayerHand\AbstractPlayerHand;

class ThreeOfAKindPlayerHand extends AbstractPlayerHand
{
    public function __construct(
        private readonly array $threeOfAKindArray,
        private readonly array $otherTwoCards,
        int                    $playerId,
    )
    {
        parent::__construct(
            array_merge($threeOfAKindArray, $otherTwoCards),
            $playerId
        );
    }

    public function getThreeOfAKindArray(): array
    {
        return $this->threeOfAKindArray;
    }

    public function getOtherTwoCards(): array
    {
        return $this->otherTwoCards;
    }

    public function compare(AbstractPlayerHand $otherHand): CompareHandResultEnum
    {
        if ($otherHand instanceof self) {
            return CompareHandResultEnum::Equal;
        }
        if ($otherHand instanceof TwoPairPlayerHand
            || $otherHand instanceof OnePairPlayerHand
            || $otherHand instanceof HighCardPlayerHand) {
            return CompareHandResultEnum::Higher;
        }

        return CompareHandResultEnum::Lower;
    }
}
