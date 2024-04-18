<?php

namespace App\Game\Poker;

enum Stage
{
    case preFlop;
    case flop;
    case turn;
    case river;

    public function returnAsView(): string
    {
        $viewFileName = match($this) {
            self::preFlop => 'pre-flop',
            self::flop => 'flop',
            self::turn => 'turn',
            self::river => 'river',
        };

        return "poker/{$viewFileName}";
    }
}
