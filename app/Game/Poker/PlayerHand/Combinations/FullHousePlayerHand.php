<?php

namespace App\Game\Poker\PlayerHand\Combinations;

use App\Game\Poker\CompareHandResultEnum;
use App\Game\Poker\PlayerHand\AbstractPlayerHand;

class FullHousePlayerHand extends AbstractPlayerHand
{
    public function __construct(
        private readonly array $threeCards,
        private readonly array $twoCards,
        int                    $playerId,
    )
    {
        parent::__construct(
            array_merge($threeCards, $twoCards),
            $playerId
        );
    }

    public function getThreeCards(): array
    {
        return $this->threeCards;
    }

    public function getTwoCards(): array
    {
        return $this->twoCards;
    }

    public function compare(AbstractPlayerHand $otherHand): CompareHandResultEnum
    {
        if ($otherHand instanceof self) {
            return CompareHandResultEnum::Equal;
        }
        if ($otherHand instanceof FourOfAkindPlayerHand
            || $otherHand instanceof StraightFlushPlayerHand
            || $otherHand instanceof RoyalFlashPlayerHand) {
            return CompareHandResultEnum::Lower;
        }

        return CompareHandResultEnum::Higher;
    }
}
