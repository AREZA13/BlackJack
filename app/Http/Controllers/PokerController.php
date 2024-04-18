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
        $this->putSaveSession($poker);
        return view('poker/pre-flop', ['pot' => $poker->getPot()], ['players' => $poker->getPlayers()]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function flop(RoundBetRequest $request): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $round = 'flop';
        return $this->flopTurnRiver($request, $round);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function turn(RoundBetRequest $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $round = 'turn';
        return $this->flopTurnRiver($request, $round);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function river(RoundBetRequest $request): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $round = 'river';
        return $this->flopTurnRiver($request, $round);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function flopTurnRiver(RoundBetRequest $request, $round): Factory|View|\Illuminate\Foundation\Application|Application
    {
        /** @var Poker $poker */
        $poker = session()->get('poker');
        $request->validated();
        $preFlopBet = $request['bet'];
        $poker->roundBetting($preFlopBet);;

        if ($round === 'turn' || 'river') {
            $poker->getOneCard($poker->getDeck());
        }

        if ($round === 'flop') {
            $poker->getFlopCards($poker->getDeck());
        }

        $this->putSaveSession($poker);
        $urlPageName = $round;
        return $this->getRoundCards($urlPageName);
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
    private function betting(RoundBetRequest $request, $page): Application|Factory|\Illuminate\Foundation\Application|View
    {
        /** @var Poker $poker */
        $poker = session()->get('poker');
        $request->validated();
        $preFlopBet = $request['bet'];
        $poker->roundBetting($preFlopBet);
        $this->putSaveSession($poker);
        return view("poker/{$page}", [
            'players' => $poker->getPlayers(),
            'pot' => $poker->getPot(),
            'tableCards' => $poker->getTableCards(),
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getRoundCards($urlPageName): Factory|\Illuminate\Foundation\Application|View|Application
    {
        /** @var Poker $poker */
        $poker = session()->get('poker');
        $this->putSaveSession($poker);
        return view("poker/{$urlPageName}", [
            'players' => $poker->getPlayers(),
            'pot' => $poker->getPot(),
            'tableCards' => $poker->getTableCards(),
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
        foreach ($poker->getPlayers() as $player) {
            $stackPlayer += $player->getStack();
        }
        $poker->tableCardsIsLessThanFive();
        $tableCards = $poker->getTableCards();
        $this->putSaveSession($poker);
        return view("poker/all-in-bet", [
            'players' => $poker->getPlayers(),
            'pot' => $stackPlayer,
            'tableCards' => $tableCards,]);
    }

    public function removeSession(Request $request): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        $request->session()->forget('poker');
        return redirect()->route("poker-start-game-page");
    }

    public function putSaveSession($sessionKey): void
    {
        session()->put('poker', $sessionKey);
        session()->save();
    }


}
