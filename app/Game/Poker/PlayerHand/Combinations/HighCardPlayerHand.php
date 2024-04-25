<?php

namespace App\Game\Poker\PlayerHand\Combinations;

use App\Game\Poker\CompareHandResultEnum;
use App\Game\Poker\PlayerHand\AbstractPlayerHand;

class HighCardPlayerHand extends AbstractPlayerHand
{
    public function compare(AbstractPlayerHand $otherHand): CompareHandResultEnum
    {
        if ($otherHand instanceof self) {
            return CompareHandResultEnum::Equal;
        }

        return CompareHandResultEnum::Lower;
    }
}
