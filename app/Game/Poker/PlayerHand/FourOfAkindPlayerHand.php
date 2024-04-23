<?php

namespace App\Game\Poker\PlayerHand;

use App\Game\Card;
use App\Game\Poker\CompareHandResultEnum;

class FourOfAkindPlayerHand extends AbstractPlayerHand
{
    public function compare(AbstractPlayerHand $otherHand): CompareHandResultEnum
    {
        if ($otherHand instanceof self) {
            return CompareHandResultEnum::Equal;
        }
        if ($otherHand instanceof StraightPlayerHand
            || $otherHand instanceof StraightFlushPlayerHand
            || $otherHand instanceof RoyalFlashPlayerHand) {
            return CompareHandResultEnum::Lower;
        }

        return CompareHandResultEnum::Higher;
    }
}
