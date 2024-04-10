<?php

namespace App\Http\Controllers;

use App\Game\Poker\Poker;
use App\Http\Requests\RoundBetRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PokerController extends Controller
{
    public function home(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('poker/start-page');
    }

    public function preFlop(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $poker = Poker::createNewGame();
        $pot = $poker->pot;
        $players = $poker->players;
        session()->put('poker', $poker);
        session()->save();
        return view('poker/preFlop', ['pot' => $pot], ['players' => $players]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function preFlopBet(RoundBetRequest $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        /** @var Poker $poker */
        $poker = session()->get('poker');
        $request->validated();
        $preFlopBet = $request['bet'];
        $poker->bettingAtPreFlop($preFlopBet);
        session()->put('poker', $poker);
        session()->save();
        return \view('poker/flop', ['pot' => $poker->pot], ['players' => $poker->players]);
    }
}
