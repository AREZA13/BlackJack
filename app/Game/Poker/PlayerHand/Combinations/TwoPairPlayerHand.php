<?php

namespace App\Game\Poker\PlayerHand\Combinations;

use App\Game\Poker\CompareHandResultEnum;
use App\Game\Poker\PlayerHand\AbstractPlayerHand;

class TwoPairPlayerHand extends AbstractPlayerHand
{
    public function compare(AbstractPlayerHand $otherHand): CompareHandResultEnum
    {
        if ($otherHand instanceof self) {
            return CompareHandResultEnum::Equal; //Todo
        }
        if ($otherHand instanceof OnePairPlayerHand
            || $otherHand instanceof HighCardPlayerHand) {
            return CompareHandResultEnum::Higher;
        }

        return CompareHandResultEnum::Lower;
    }
}
