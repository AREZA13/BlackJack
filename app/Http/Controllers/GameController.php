<?php

namespace App\Http\Controllers;

use App\Game\Deck;

class GameController extends Controller
{
    public function index(): void
    {
        $testClass = new Deck();
        $newCard = $testClass->getOneCardFullShuffledDeckOnTheTable();
        var_dump("$newCard->nominal of $newCard->suit");
    }
}
