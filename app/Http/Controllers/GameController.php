<?php

namespace App\Http\Controllers;

use App\Game\Deck;
use App\Game\Nominal;
use App\Game\Suit;

class GameController extends Controller
{
    public function index(): void
    {
        $testClass = new Deck();
        $newCard = $testClass->getOneCardFullShuffledDeckOnTheTable();

        var_dump("{$newCard->nominal->name} of {$newCard->suit->name}");
    }
}
