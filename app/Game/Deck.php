<?php

namespace App\Game;

class Deck
{
    private array $fullDeck;

    public function __construct()
    {
        $this->fullDeck = self::fullShuffledDeck();
    }

    private function fullShuffledDeck(): array
    {
        $suit = ["heart", "club", "diamond", "spades"];
        $nominal = ["2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K", "A"];
        $fullDeck = [];
        foreach ($suit as $oneOfSuit) {
            foreach ($nominal as $oneOfNominal) {
                $fullDeck[] = "$oneOfNominal of $oneOfSuit";
            }
        }
        shuffle($fullDeck);
        return $fullDeck;
    }

    public function getOneCardFullShuffledDeckOnTheTable(): string
    {
        return array_pop($this->fullDeck);
    }
}
