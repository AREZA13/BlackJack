<?php

namespace App\Game;

use Illuminate\Http\Request;

class BlackJack
{
    public function __construct(
        public Deck  $deck,
        public array $pocketCards,
    )
    {
    }

    public static function fromSession(Request $request): self
    {
        $deck = $request->session()->get('fullDeck');
        $pocketCards = $request->session()->get('pocketCards');
        return (new BlackJack($deck, $pocketCards));
    }

    public static function oldIfPossible(Request $request): self
    {
        /** @var Deck $deck */
        if ($request->session()->has('fullDeck')) {
            $deck = $request->session()->get('fullDeck');
        }

        if ((empty($deck)) || $deck->getCardsCount() < 10) {
            $deck = Deck::fullShuffledDeck();
        }

        return (new BlackJack($deck, []));
    }

    public function forIndex(Request $request): array
    {
        $this->pocketCards = [
            $this->deck->getOneCardFullShuffledDeckOnTheTable(),
            $this->deck->getOneCardFullShuffledDeckOnTheTable(),
        ];
        $gamerPoints = $this->calcGamerCards();
        $gamerProbability = $this->probabilityOfFailScores($gamerPoints);

        $request->session()->put('fullDeck', $this->deck);
        $request->session()->put('pocketCards', $this->pocketCards);
        $request->session()->save();
        return [$this->pocketCards, $gamerProbability, $gamerPoints];
    }

    public function forOneMoreCardPage(Request $request): array
    {
        $this->pocketCards[] = $this->deck->getOneCardFullShuffledDeckOnTheTable();
        $gamerPoints = $this->calcGamerCards();
        $gamerProbability = $this->probabilityOfFailScores($gamerPoints);
        $request->session()->put('fullDeck', $this->deck);
        $request->session()->put('pocketCards', $this->pocketCards);
        $request->session()->save();
        return [$this->pocketCards, $gamerProbability, $gamerPoints];
    }

    public function forEndGameMessage(): string
    {
        return $this->endGameMessage();
    }


    private function calcGamerCards(): int
    {
        $sum = 0;
        foreach ($this->pocketCards as $card) {
            $sum += $card->getAsPoints();
        }
        return $sum;
    }


    private function probabilityOfFailScores(int $gamerPoints): int
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

    private function endGameMessage(): string
    {
        $gamerScore = $this->calcGamerCards($this->pocketCards);

        if ($gamerScore > 21) {
            return "<button type='button' disabled class='btn btn-light'> YOU LOOSE  <br> Your score " . $gamerScore . "</button>";
        }

        $dealerScore = rand(15, 22);

        if ($dealerScore < $gamerScore) {
            return "<button type='button' disabled class='btn btn-light'> Dealer has " . $dealerScore . "</button>" . "<br>  <button type='button' disabled class='btn btn-success'>   Victory " . " with " . $gamerScore . "</button>";
        }
        if ($dealerScore === 21) {
            return "Dealer wins with BlackJack";
        } else {
            return "<button type='button' disabled class='btn btn-danger'>Dealer win with " . $dealerScore .  "</button>" . "<br>" . " <button type='button' disabled class='btn btn-light'> Your score is " . $gamerScore . "</button>";
        }
    }
}
