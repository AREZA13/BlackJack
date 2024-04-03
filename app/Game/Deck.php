<?php

namespace App\Game;

use SessionHandler;
use Symfony\Component\Uid\Factory\TimeBasedUuidFactory;
use function Laravel\Prompts\alert;
use function PHPUnit\Framework\isEmpty;

class Deck
{
    /** @param Card[] $deck */
    public function __construct(private array $deck)
    {
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

    public function getCardsCount(): int
    {
        return count($this->deck);
    }

    public function getOneCard(): Card
    {
        return array_pop($this->deck);
    }

}
