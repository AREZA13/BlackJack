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
        /** @var Poker $poker */
        $poker = Poker::checkPreviousStageAndReturnView();

        return view($poker->getStage()->returnAsView(), [
            'players' => $poker->getPlayers(),
            'pot' => $poker->getPot(),
            'tableCards' => $poker->getTableCards(),
        ]);
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
        $poker->checkCurrentStage($previousStage);
        $poker->savePokerInSession();
        return redirect()->back();
    }
}
