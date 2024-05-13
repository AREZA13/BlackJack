<?php

namespace App\Game;

readonly class Card
{
    public function __construct(
        public Suit    $suit,
        public Nominal $nominal,
    )
    {
    }

    public function getAsString(): string
    {
        return "{$this->nominal->name} of {$this->suit->name}";
    }

    public function getAsTwoLettersString(): string
    {
        return "{$this->nominal->getAsOneLetter()}{$this->suit->getAsOneLetter()}";
    }

    public function getAsImagePath(): string
    {
        return "../../images/card/{$this->getAsTwoLettersString()}.png";
    }

    public function getAsBackCardImage(): string
    {
        return "../../images/backCard/backCard.png";
    }

    public function getAsPoints(): int
    {
        return match ($this->nominal) {
            Nominal::Ace => 11,
            Nominal::Two => 2,
            Nominal::Three => 3,
            Nominal::Four => 4,
            Nominal::Five => 5,
            Nominal::Six => 6,
            Nominal::Seven => 7,
            Nominal::Eight => 8,
            Nominal::Nine => 9,
            Nominal::Ten, Nominal::Jack, Nominal::Queen, Nominal::King => 10,
        };
    }

    public function __toString(): string
    {
        return $this->getAsTwoLettersString();
    }
}
