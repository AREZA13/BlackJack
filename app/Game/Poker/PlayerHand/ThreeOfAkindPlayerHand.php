<?php

namespace App\Game\Poker\PlayerHand;

use App\Game\Card;
use App\Game\Poker\CompareHandResultEnum;

class FlashPlayerHand extends AbstractPlayerHand
{
    public function compare(AbstractPlayerHand $otherHand): CompareHandResultEnum
    {
        /**
         * @param array{0: Card, 1: Card, 2: Card, 3: Card, 4: Card, 5: Card, 6: Card} $arrayOfSevenCards
         */

    }
}
