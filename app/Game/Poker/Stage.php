<?php

namespace App\Game\Poker;

enum Stage
{
    case NewGame;
    case PreFlop;
    case Flop;
    case Turn;
    case River;
    case Results;

    public function returnAsView(): string
    {
        $viewFileName = match ($this) {
            self::PreFlop => 'pre-flop',
            self::Flop => 'flop',
            self::Turn => 'turn',
            self::River => 'river',
            self::Results => 'results',
        };

        return "poker/{$viewFileName}";
    }
}
