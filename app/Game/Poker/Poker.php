<?php

namespace App\Game\Poker;

use App\Game\Deck;
use App\Http\Controllers\PokerController;
use App\Http\Requests\RoundBetRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Poker
{

    /**
     * @param Player[] $players
     */
    public function __construct(
        private readonly Deck  $deck,
        public Stage           $stage,
        private readonly array $players,
        private int            $pot = 0,
        private array          $tableCards = [],

    )
    {
    }

    /**
     * @return Stage
     */
    public function getStage(): Stage
    {
        return $this->stage;
    }

    /**
     * @return Deck
     */
    public function getDeck(): Deck
    {
        return $this->deck;
    }

    /**
     * @return array
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @return int
     */
    public function getPot(): int
    {
        return $this->pot;
    }

    /**
     * @return array
     */
    public function getTableCards(): array
    {
        return $this->tableCards;
    }

    public static function createNewGame(): Poker
    {
        $deck = Deck::fullShuffledDeck();
        $players = self::getNewPlayers($deck);
        return new self($deck, Stage::PreFlop, $players);
    }

    private static function getNewPlayers(Deck $deck): array
    {
        $players = [];
        $stack = 100;
        $roundBet = 0;
        for ($i = 1; $i < 4; $i++) {
            $pocketCards = [$deck->getOneCard(), $deck->getOneCard()];
            $players[] = new Player($pocketCards, $stack, $roundBet);
        }
        return $players;
    }

    /**
     * @param $roundBet
     * @return void
     */
    public function roundBetting($roundBet): void
    {
        $players = $this->players;
        $masterPlayer = $players[0];
        $this->pot += $masterPlayer->roundBet($roundBet);
        array_shift($players);
        foreach ($players as $player) {
            try {
                $playerBet = $player->call($roundBet);
            } catch (\RuntimeException $exception) {
                continue;
            }
            $this->pot += $playerBet;
        }
    }

    /**
     * @param Deck $deck
     * @return array
     */
    public function getFlopCards(Deck $deck): array
    {
        $this->tableCards = [$deck->getOneCard(), $deck->getOneCard(), $deck->getOneCard()];
        return $this->tableCards;
    }

    public function getOneCard(Deck $deck): array
    {
        $this->tableCards[] = $deck->getOneCard();
        return $this->tableCards;
    }

    public function tableCardsIsLessThanFive(): void
    {
        if (count($this->tableCards) !== 5) {
            for ($i = count($this->tableCards); $i < 5; $i++) {
                $this->tableCards = $this->getOneCard($this->deck);
            }
        }
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function allInBet(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        /** @var ?Poker $poker */
        $poker = session()->get('poker');
        $stackPlayer = 0;

        foreach ($poker->getPlayers() as $player) {
            $stackPlayer += $player->getStack();
        }
        $poker->tableCardsIsLessThanFive();
        $tableCards = $poker->getTableCards();
        PokerController::class->savePokerInSession($poker);
        return view("poker/all-in-bet", [
            'players' => $poker->getPlayers(),
            'pot' => $stackPlayer,
            'tableCards' => $tableCards,]);
    }

    public function checkCurrentStage($previousStage)
    {
        if ($previousStage === Stage::PreFlop) {
            $this->getFlopCards($this->getDeck());
            $this->stage = Stage::Flop;
        }

        if ($previousStage === Stage::Flop) {
            $this->getOneCard($this->getDeck());
            $this->stage = Stage::Turn;
        }

        if ($previousStage === Stage::Turn) {
            $this->getOneCard($this->getDeck());
            $this->stage = Stage::River;
        }

        if ($previousStage === Stage::River) {
            $this->stage = Stage::Results;
        }

        return $previousStage;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws ContainerExceptionInterfaceDe
     * @throws NotFoundExceptionInterface
     */
    public static function checkPreviousStageAndReturnView()
    {
        $poker = session()->get('poker');

        if (!is_null($poker)) {
            return $poker;
        }

        $poker = Poker::createNewGame();
        $poker->savePokerInSession();
        return $poker;
    }

    public function removeSession(RoundBetRequest $request): RedirectResponse
    {
        $request->session()->forget('poker');
        return redirect()->route("choose-game");
    }

    public function savePokerInSession(): void
    {
        session()->put('poker', $this);
        session()->save();
    }
}
