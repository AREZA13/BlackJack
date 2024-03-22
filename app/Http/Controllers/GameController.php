<?php

namespace App\Http\Controllers;

use App\Game\Game;

class GameController extends Controller
{
    public function index(): void
    {
        $testClass = new Game();
        var_dump($testClass->getOneCardFullShuffledDeckOnTheTable());
    }
}
