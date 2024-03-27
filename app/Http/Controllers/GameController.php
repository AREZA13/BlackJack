<?php

namespace App\Http\Controllers;

use App\Game\BlackJack;
use Illuminate\Http\Request;

class GameController extends Controller

{
    public function home(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('start-page');
    }

    public function start(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $blackJack = BlackJack::oldIfPossible($request);
        [$pocketCards, $gamerProbability, $gamerPoints] = $blackJack->forIndex($request);
        return view('get-two-cards-game-page', ['pocketCards' => $pocketCards], ['gamerProbability' => $gamerProbability, 'gamerPoints' => $gamerPoints]);
    }

    public function oneMoreCardPage(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $blackJack = BlackJack::fromSession($request);
        [$pocketCards, $gamerProbability, $gamerPoints] = $blackJack->forOneMoreCardPage($request);
        return view('get-two-cards-game-page', ['pocketCards' => $pocketCards], ['gamerProbability' => $gamerProbability, 'gamerPoints' => $gamerPoints]);
    }

    public function removeSession(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $request->session()->forget('fullDeck');
        return redirect("/start-game-page");
    }

    public function generateRandomDealerScore(Request $request): string
    {
        $blackJack = BlackJack::fromSession($request);
        $message = $blackJack->forEndGameMessage();
        return view('finish-page', ['message' => $message]);
    }
}

