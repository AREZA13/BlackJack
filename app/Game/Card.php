<?php

namespace App\Game;

readonly class Card
{
    public function __construct(
        public Suit $suit,
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
}
