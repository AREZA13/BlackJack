<?php

namespace App\Http\Controllers;

use App\Game\Poker\NoPokerInSessionException;
use App\Game\Poker\Poker;
use App\Game\Poker\Stage;
use App\Http\Requests\RoundBetRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use function view;

class PokerController extends Controller
{

    public function home(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('poker/start-page');
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function get(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $poker = Poker::getPokerFromSessionOrMakeNew();

        if ($poker->stage === Stage::Results) {
            return view($poker->getStage()->returnAsView(), [
                'players' => $poker->getPlayers(),
                'pot' => $poker->getPot(),
                'tableCards' => $poker->getTableCards(),
                'winnerPlayers' => $poker->getWinnerPlayers(),
            ]);
        }

        return view($poker->getStage()->returnAsView(), [
            'players' => $poker->getPlayers(),
            'pot' => $poker->getPot(),
            'tableCards' => $poker->getTableCards(),
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws NoPokerInSessionException
     */
    public function post(RoundBetRequest $request): RedirectResponse
    {
        $poker = $this->getPokerFromSession();
        $previousStage = $poker->getStage();
        $request->validated();
        $bet = $request['bet'];
        $poker->roundBetting($bet);
        $poker->executeCurrentStageAndSetNextStage($previousStage);
        $poker->savePokerInSession();
        return redirect()->back();
    }

    public function removeSession(Request $request): RedirectResponse
    {
        $request->session()->forget('poker');
        return redirect()->route("choose-game");
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws NoPokerInSessionException
     */
    public function allInBet(): RedirectResponse
    {
        $poker = $this->getPokerFromSession();
        $poker->allInBet();
        $poker->savePokerInSession();

        return redirect()->route("pokerGet");
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws NoPokerInSessionException
     */
    private function getPokerFromSession(): Poker
    {
        $poker = session()->get('poker');

        if (is_null($poker)) {
            throw new NoPokerInSessionException();
        }
        return $poker;
    }
}
