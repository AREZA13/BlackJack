<?php

namespace App\Http\Controllers;

use App\Game\Poker\Poker;
use App\Http\Requests\RoundBetRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use function view;

class PokerController extends Controller
{
    public function home(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('poker/start-page');
    }

    public function preFlop(): View|\Illuminate\Foundation\Application|Factory|Application
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
    public function flop(RoundBetRequest $request): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $poker = session()->get('poker');
        $request->validated();
        $preFlopBet = $request['bet'];
        $poker->roundBetting($preFlopBet);
        $poker->getFlopCards($poker->deck);
        session()->put('poker', $poker);
        session()->save();
        $urlPageName = 'flop';
        return $this->getRoundCards($urlPageName);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function turn(RoundBetRequest $request): Factory|\Illuminate\Foundation\Application|View|Application
    {
        /** @var Poker $poker */
        $poker = session()->get('poker');
        $request->validated();
        $preFlopBet = $request['bet'];
        $poker->roundBetting($preFlopBet);;
        $poker->getOneCard($poker->deck);
        session()->put('poker', $poker);
        session()->save();
        $urlPageName = 'turn';
        return $this->getRoundCards($urlPageName);

    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function river(RoundBetRequest $request): Factory|\Illuminate\Foundation\Application|View|Application
    {
        /** @var Poker $poker */
        $poker = session()->get('poker');
        $request->validated();
        $preFlopBet = $request['bet'];
        $poker->roundBetting($preFlopBet);
        $poker->getOneCard($poker->deck);
        session()->put('poker', $poker);
        session()->save();
        $urlPageName = 'river';
        return $this->getRoundCards($urlPageName);
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function betting(RoundBetRequest $request, $page): Application|Factory|\Illuminate\Foundation\Application|View
    {
        /** @var Poker $poker */
        $poker = session()->get('poker');
        $request->validated();
        $preFlopBet = $request['bet'];
        $poker->roundBetting($preFlopBet);
        session()->put('poker', $poker);
        session()->save();
        return view("poker/{$page}", [
            'players' => $poker->players,
            'pot' => $poker->pot,
            'tableCards' => $poker->tableCards,
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function riverBet(RoundBetRequest $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $urlPageName = 'river';
        return $this->betting($request, $urlPageName);
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getRoundCards($urlPageName): Factory|\Illuminate\Foundation\Application|View|Application
    {
        /** @var Poker $poker */
        $poker = session()->get('poker');
        session()->put('poker', $poker);
        session()->save();
        return view("poker/{$urlPageName}", [
            'players' => $poker->players,
            'pot' => $poker->pot,
            'tableCards' => $poker->tableCards,
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function allInBet(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        /** @var Poker $poker */
        $poker = session()->get('poker');
        $stackPlayer = 0;
        foreach ($poker->players as $player) {
            $stackPlayer += $player->getStack();
        }
        $poker->tableCardsIsLessThanFive();
        $tableCards = $poker->tableCards;
        session()->put('poker', $poker);
        session()->save();
        return view("poker/all-in-bet", [
            'players' => $poker->players,
            'pot' => $stackPlayer,
            'tableCards' => $tableCards,]);
    }

    public function removeSession(Request $request): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        $request->session()->forget('poker');
        return redirect()->route("poker-start-game-page");
    }


}
