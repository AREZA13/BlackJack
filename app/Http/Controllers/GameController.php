<?php

namespace App\Http\Controllers;

use App\Game\Deck;
use App\Game\Nominal;
use App\Game\Suit;
use Illuminate\Http\Request;


class GameController extends Controller

{
    public function index(Request $request): void
    {
        session_start();

        if (!$request->session()->has('fullDeck')) {
            echo 'huy1';
            $deck = Deck::fullShuffledDeck();
        }
        else {
            $deck = $request->session()->get('fullDeck');
            echo 'huy2';
//            Deck::buildFromDeck($deck);
        }
//        $request->session()->put('fullDeck', $deck);
        dd($deck);

//        $newCard = $deck->getOneCardFullShuffledDeckOnTheTable();
//        var_dump("{$newCard->nominal->name} of {$newCard->suit->name}");
//
    }
}

