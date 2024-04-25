<?php

namespace App\Game\Poker\PlayerHand\Combinations;

use App\Game\Poker\CompareHandResultEnum;
use App\Game\Poker\PlayerHand\AbstractPlayerHand;

class StraightPlayerHand extends AbstractPlayerHand
{
    public function compare(AbstractPlayerHand $otherHand): CompareHandResultEnum
    {
        if ($otherHand instanceof self) {
            return CompareHandResultEnum::Equal;
        }
        if ($otherHand instanceof ThreeOfAKindPlayerHand
            || $otherHand instanceof TwoPairPlayerHand
            || $otherHand instanceof OnePairPlayerHand
            || $otherHand instanceof HighCardPlayerHand) {
            return CompareHandResultEnum::Lower;
        }
        return CompareHandResultEnum::Higher;
    }
}
