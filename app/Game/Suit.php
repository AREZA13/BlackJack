<?php

namespace App\Game;

enum Suit
{
    case Hearts;
    case Diamonds;
    case Clubs;
    case Spades;

    public function getAsOneLetter(): string
    {
        return match($this) {
            self::Spades => 'S',
            self::Clubs => 'C',
            self::Diamonds => 'D',
            self::Hearts => 'H',
        };
    }
}
