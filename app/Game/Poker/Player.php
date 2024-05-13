<?php

namespace App\Game\Poker;

use App\Game\Card;
use App\Game\Poker\PlayerHand\AbstractPlayerHand;
use App\Game\Poker\PlayerHand\PlayerHandFactory;
use http\Exception\RuntimeException;

class Player
{
    /**
     * @param Card[] $pocketCards
     */
    public function __construct(
        private array       $pocketCards,
        private int         $stack,
        public readonly int $playerId,
        private int         $roundBet = 0,
        private bool        $isFallen = false,
    )
    {
    }

    /** @return Card[] */
    public function getPocketCards(): array
    {
        return $this->pocketCards;
    }

    public function getStack(): int
    {
        return $this->stack;
    }


    public function getPlayerId(): int
    {
        return $this->playerId;
    }

    public function randomRoundBet(): int
    {
        $randomBet = rand(1, $this->stack / 10);
        return $this->roundBet($randomBet);
    }

    public function roundBet(int $roundBet): int
    {
        $this->roundBet = $roundBet;
        $this->stack -= $this->roundBet;
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

    /**
     * @param Card[] $tableCards
     */
    public function getPlayerHand(array $tableCards): AbstractPlayerHand
    {
        $arrayOfSevenCards = array_merge($tableCards, $this->pocketCards);
        return (new PlayerHandFactory($arrayOfSevenCards, $this->playerId))->getPlayerHand();
    }
}
