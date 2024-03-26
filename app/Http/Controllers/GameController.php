<?php

namespace App\Http\Controllers;

use App\Game\Card;
use App\Game\Deck;
use Illuminate\Http\Request;

class GameController extends Controller

{
    public function home()
    {
        return view('start-game-page');
    }

    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $deck = (!$request->session()->has('fullDeck'))
            ? Deck::fullShuffledDeck()
            : $request->session()->get('fullDeck');

        $pocketCards = [
            $deck->getOneCardFullShuffledDeckOnTheTable(),
            $deck->getOneCardFullShuffledDeckOnTheTable(),
        ];

        $gamerPoints = $this->calcGamerCards($pocketCards);
        $gamerProbability = $this->probabilityOfFailScores($gamerPoints);

        $request->session()->put('fullDeck', $deck);
        $request->session()->put('pocketCards', $pocketCards);
        $request->session()->save();
        return view('get-two-cards-game-page', ['pocketCards' => $pocketCards], ['gamerProbability' => $gamerProbability]);
    }

    public function oneMoreCardPage(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $pocketCards = $request->session()->get('pocketCards');
        $gamerPoints = $this->calcGamerCards($pocketCards);
        $gamerProbability = $this->probabilityOfFailScores($gamerPoints);
        /** @var Deck $deck */
        $deck = $request->session()->get('fullDeck');
        /** @var Card[] $pocketCards */
        $pocketCards[] = $deck->getOneCardFullShuffledDeckOnTheTable();
        $request->session()->put('pocketCards', $pocketCards);
        $request->session()->save();
        return view('get-two-cards-game-page', ['pocketCards' => $pocketCards], ['gamerProbability' => $gamerProbability]);
    }

    public function removeSession(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $request->session()->forget('fullDeck');
        return redirect("/start-game-page");
    }

    /** @param Card[] $pocketCards */
    public function calcGamerCards(array $pocketCards): int
    {
        $sum = 0;
        foreach ($pocketCards as $card) {
            $sum += $card->getAsPoints();
        }
        return $sum;
    }

    public function generateRandomDealerScore(Request $request): string
    {
        $pocketCards = $request->session()->get('pocketCards');
        $gamerScore = $this->calcGamerCards($pocketCards);

        if ($gamerScore > 21) {
            return "YOU LOOSE" . " <br> Your score " . $gamerScore;
        }

        $dealerScore = rand(15, 22);

        if ($dealerScore < $gamerScore) {
            return "Dealer has " . $dealerScore . " <br> YOU WIN" . " <br> Your score " . $gamerScore;
        }
        if ($dealerScore === 21) {
            return "Dealer wins with BlackJack";
        } else {
            return "Dealer win with " . $dealerScore . "  score  <br>" . "Your score is " . $gamerScore;
        }
    }

    public function probabilityOfFailScores(int $gamerPoints): int
    {
        return match ($gamerPoints) {
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 => 0,
            12 => 31,
            20 => 92,
            19 => 85,
            18 => 77,
            17 => 69,
            16 => 62,
            15 => 58,
            14 => 56,
            13 => 39,
            default => 100,
        };
    }
}

