<?php

namespace App\Http\Controllers;

use App\Game\Poker\Poker;

class PokerController extends Controller
{
    public function home(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('poker/start-page');
    }

    public function preFlop(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $newGame = Poker::createNewGame();
        $pot = $newGame->pot;
        $players = $newGame->players;
        return view('poker/preFlop', ['pot' => $pot], ['players' => $players]);
    }
}
