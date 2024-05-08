<?php

namespace App\Game\Poker\PlayerHand\Combinations;

use App\Game\Card;
use App\Game\Poker\CompareHandResultEnum;
use App\Game\Poker\PlayerHand\AbstractPlayerHand;

class TwoPairPlayerHand extends AbstractPlayerHand
{

    public function __construct(
        private readonly array $highestPair,
        private readonly array $secondPair,
        private readonly Card  $highestCard,
        int                    $playerId,
    )
    {
        parent::__construct(
            array_merge($highestPair, $secondPair, [$highestCard]),
            $playerId
        );
    }

    public function getHighestCard(): Card
    {
        return $this->highestCard;
    }

    public function getSecondPair(): array
    {
        return $this->secondPair;
    }

    public function getHighestPair(): array
    {
        return $this->highestPair;
    }

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
