<?php

namespace App\Game;

class Deck
{
    /** @var Card[] $fullDeck */
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
                $fullDeck[] = new Card($oneOfSuit, $oneOfNominal);
            }
        }
        shuffle($fullDeck);
        return $fullDeck;
    }

    public function getOneCardFullShuffledDeckOnTheTable(): Card
    {
        return array_pop($this->fullDeck);
    }
}
