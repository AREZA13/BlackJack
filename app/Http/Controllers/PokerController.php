<?php

namespace App\Http\Controllers;

use App\Game\Poker\Poker;
use App\Game\Poker\Stage;
use App\Http\Requests\RoundBetRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use function view;

class PokerController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get()
    {
        /** @var ?Poker $poker */
        $poker = session()->get('poker');

        if (is_null($poker)) {
            $poker = Poker::createNewGame();
            $this->savePokerInSession($poker);
        }

        return view($poker->getStage()->returnAsView(), [
            'players' => $poker->getPlayers(),
            'pot' => $poker->getPot(),
            'tableCards' => $poker->getTableCards(),
        ]);
    }

    public function home(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('poker/start-page');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function post(RoundBetRequest $request)
    {
        /** @var Poker $poker */
        $poker = session()->get('poker');
        $previousStage = $poker->getStage();
        $request->validated();
        $bet = $request['bet'];
        $poker->roundBetting($bet);

        if ($previousStage === Stage::PreFlop) {
            $poker->getFlopCards($poker->getDeck());
            $poker->stage = Stage::Flop;
        }

        if ($previousStage === Stage::Flop) {
            $poker->getOneCard($poker->getDeck());
            $poker->stage = Stage::Turn;
        }

        if ($previousStage === Stage::Turn) {
            $poker->getOneCard($poker->getDeck());
            $poker->stage = Stage::River;
        }

        if ($previousStage === Stage::River) {
            $poker->stage = Stage::Results;
        }

        $this->savePokerInSession($poker);
        return redirect()->back();
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
        $this->savePokerInSession($poker);
        return view("poker/all-in-bet", [
            'players' => $poker->getPlayers(),
            'pot' => $stackPlayer,
            'tableCards' => $tableCards,]);
    }

    public function removeSession(Request $request): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        $request->session()->forget('poker');
        return redirect()->route("pokerGet");
    }

    public function savePokerInSession(Poker $poker): void
    {
        session()->put('poker', $poker);
        session()->save();
    }
}
