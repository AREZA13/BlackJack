<?php

namespace App\Http\Controllers;

use App\Game\Card;
use App\Game\Deck;
use Illuminate\Http\Request;


class GameController extends Controller

{
    public function index(Request $request): void
    {
        $deck = (!$request->session()->has('fullDeck'))
            ? Deck::fullShuffledDeck()
            : $request->session()->get('fullDeck');

        $pocketCards = [
            $deck->getOneCardFullShuffledDeckOnTheTable(),
            $deck->getOneCardFullShuffledDeckOnTheTable()
        ];

        /** @var Card $card */
        foreach ($pocketCards as $card) {
            var_dump($card->getAsString());
        }

        $request->session()->put('fullDeck', $deck);
        $request->session()->save();
        dd($deck);
    }
}

