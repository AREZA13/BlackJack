<?php

namespace App\Game;

use SessionHandler;
use Symfony\Component\Uid\Factory\TimeBasedUuidFactory;

class Deck
{
    /** @var Card[] $fullDeck */
    private array $fullDeck;

    public function __construct(array $fullDeck)
    {
        $this->fullDeck = $fullDeck;
    }

    public static function fullShuffledDeck(): self
    {
        $suit = [Suit::Hearts, Suit::Clubs, Suit::Diamonds, Suit::Spades];
        $nominal = [Nominal::Ace, Nominal::Two, Nominal::Three, Nominal::Four, Nominal::Five, Nominal::Six, Nominal::Seven, Nominal::Eight, Nominal::Nine, Nominal::Ten, Nominal::Jack, Nominal::Queen, Nominal::King];
        $fullDeck = [];
        foreach ($suit as $oneOfSuit) {
            foreach ($nominal as $oneOfNominal) {
                $fullDeck[] = new Card($oneOfSuit, $oneOfNominal);
            }
        }
        shuffle($fullDeck);
        return new self($fullDeck);
    }

    public function getOneCardFullShuffledDeckOnTheTable(): Card
    {
        return array_pop($this->fullDeck);
    }

    /**
     * built from saved session
     */
    public static function buildFromDeck($fullDeck): self {
        return new self ($fullDeck);
    }


}
