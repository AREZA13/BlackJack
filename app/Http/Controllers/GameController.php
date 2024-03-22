<?php

namespace App\Http\Controllers;

use App\Game\Deck;

class GameController extends Controller
{
    public function index(): void
    {
        $testClass = new Deck();
        var_dump($testClass->getOneCardFullShuffledDeckOnTheTable());
    }
}
