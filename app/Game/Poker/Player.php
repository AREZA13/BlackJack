<?php

namespace App\Game\Poker;

use App\Game\Card;
use http\Exception\RuntimeException;

class Player
{
    /**
     * @param Card[] $pocketCards
     */
    public function __construct(
        private array $pocketCards,
        private int   $stack,
        private int   $roundBet = 0,
        private bool  $isFallen = false,
    )
    {
    }

    /** @return Card[] */
    public function getPocketCards(): array
    {
        return $this->pocketCards;
    }

    public function randomRoundBet(): int
    {
        $randomBet = rand(1, $this->stack / 10);
        return $this->roundBet($randomBet);
    }

    public function roundBet(int $roundBet): int
    {
        $this->roundBet = $roundBet;
        $this->stack = $this->stack - $this->roundBet;
        return $this->roundBet;
    }

    public function call(int $largestPlayerBet): int
    {
        if ($largestPlayerBet > $this->stack) {
            $this->isFallen = true;
            throw new RuntimeException("not enough largest player bet");
        }

        return $this->roundBet($largestPlayerBet);
    }

    public function isFallen(): bool
    {
        return $this->isFallen;
    }
}
