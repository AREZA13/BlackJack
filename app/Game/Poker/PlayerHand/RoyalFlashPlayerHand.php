<?php

namespace App\Game\Poker\PlayerHand;

use App\Game\Card;
use App\Game\Poker\CompareHandResultEnum;

class RoyalFlashPlayerHand extends AbstractPlayerHand
{
    public function compare(AbstractPlayerHand $otherHand): CompareHandResultEnum
    {
        if ($otherHand instanceof self) {
            return CompareHandResultEnum::Equal;
        }

        return CompareHandResultEnum::Higher;
    }
}
