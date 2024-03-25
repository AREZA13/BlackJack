<?php

namespace App\Http\Controllers;

use App\Game\Card;
use App\Game\Deck;
use App\Game\Suit;
use Illuminate\Http\Request;


class GameController extends Controller

{
    public function home()
    {
        return view('start-game-page');
    }

    public function index(Request $request)
    {
        $deck = (!$request->session()->has('fullDeck'))
            ? Deck::fullShuffledDeck()
            : $request->session()->get('fullDeck');

        $pocketCards = [
            $deck->getOneCardFullShuffledDeckOnTheTable(),
            $deck->getOneCardFullShuffledDeckOnTheTable(),
                    ];

        $request->session()->put('fullDeck', $deck);
        $request->session()->save();

        return view('get-two-cards-game-page', ['pocketCards' => $pocketCards]);
//        dd($deck);
    }
    public function removeSession(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $request->session()->forget('fullDeck');
        return redirect("/start-game-page");
    }
}

