<?php

namespace App\Game;

enum Nominal
{
    case Two;
    case Three;
    case Four;
    case Five;
    case Six;
    case Seven;
    case Eight;
    case Nine;
    case Ten;
    case Jack;
    case Queen;
    case King;
    case Ace;

    public function getAsOneLetter(): string
    {
        return match ($this) {
            self::Ace => 'A',
            self::Two => '2',
            self::Three => '3',
            self::Four => '4',
            self::Five => '5',
            self::Six => '6',
            self::Seven => '7',
            self::Eight => '8',
            self::Nine => '9',
            self::Ten => '10',
            self::Jack => 'J',
            self::Queen => 'Q',
            self::King => 'K',
        };
    }

    public function getAsNumber(): int
    {
        return match ($this) {
            self::Ace => 14,
            self::Two => 2,
            self::Three => 3,
            self::Four => 4,
            self::Five => 5,
            self::Six => 6,
            self::Seven => 7,
            self::Eight => 8,
            self::Nine => 9,
            self::Ten => 10,
            self::Jack => 11,
            self::Queen => 12,
            self::King => 13,
        };
    }
}
