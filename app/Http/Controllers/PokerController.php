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
    public function preFlopBet(RoundBetRequest $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        /** @var Poker $poker */
        $poker = session()->get('poker');
        $request->validated();
        $preFlopBet = $request['bet'];
        $poker->bettingAtPreFlop($preFlopBet);
        $poker->getFlopCards($poker->deck);
        session()->put('poker', $poker);
        session()->save();
        return view('poker/preFlopJs', [
            'pot' => $poker->pot,
            'players' => $poker->players
        ]);
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
        $poker->bettingAtPreFlop($preFlopBet);
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
    public function flopBet(RoundBetRequest $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $urlPageName = 'flopJs';
        return $this->betting($request, $urlPageName);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function turnBet(RoundBetRequest $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $urlPageName = 'turnJs';
        return $this->betting($request, $urlPageName);
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
    public function flop(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $poker = session()->get('poker');
        $poker->getFlopCards($poker->deck);
        $urlPageName = 'flop';
        return $this->getRoundCards($urlPageName);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function turn(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        /** @var Poker $poker */
        $poker = session()->get('poker');
        $poker->getOneCard($poker->deck);
        $urlPageName = 'turn';
        return $this->getRoundCards($urlPageName);

    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function river(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        /** @var Poker $poker */
        $poker = session()->get('poker');
        $poker->getOneCard($poker->deck);
        $urlPageName = 'river';
        return $this->getRoundCards($urlPageName);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function allInBet(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        /** @var Poker $poker */
        $poker = session()->get('poker');
        $tableCards = $poker->tableCards;
        $stackPlayer = 0;
        $pot = $poker->pot;

        foreach ($poker->players as $player) {
            $stackPlayer += $player->getStack();

        }
        if (count($tableCards) !== 5) {
            for ($i = count($poker->tableCards); $i < 5; $i++) {
                $tableCards = $poker->getOneCard($poker->deck);
            }
            session()->put('poker', $poker);
            session()->save();
            return view("poker/all-in-bet", [
                'players' => $poker->players,
                'pot' => $stackPlayer,
                'tableCards' => $tableCards,]);
        }

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
