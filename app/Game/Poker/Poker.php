<?php

namespace App\Game\Poker;

use App\Game\Deck;
use App\Game\Poker\PlayerHand\AbstractPlayerHand;
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
        for ($playerId = 0; $playerId < 3; $playerId++) {
            $pocketCards = [$deck->getOneCard(), $deck->getOneCard()];
            $players[] = new Player($pocketCards, $stack, $playerId, $roundBet);
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

    public function dealTableCardsIfLessThanFive(): void
    {
        if (count($this->tableCards) !== 5) {
            for ($i = count($this->tableCards); $i < 5; $i++) {
                $this->tableCards = $this->getOneCard($this->deck);
            }
        }
    }

    public function allInBet(): void
    {
        foreach ($this->getPlayers() as $player) {
            $this->pot += $player->getStack();
        }
        $this->dealTableCardsIfLessThanFive();
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
     * @throws NotFoundExceptionInterface
     */
    public static function checkPreviousStageAndReturnView(): self
    {
        $poker = session()->get('poker');

        if (!is_null($poker)) {
            return $poker;
        }

        $poker = Poker::createNewGame();
        $poker->savePokerInSession();
        return $poker;
    }


    public function savePokerInSession(): void
    {
        session()->put('poker', $this);
        session()->save();
    }

    /** @return int[] */
    public function getWinnersId(): array
    {
        /** @var AbstractPlayerHand[] $playerHands */
        $playerHands = $this->getAllPlayerHands();
        $playerHandsOfWinners = [0 => $playerHands[0]];
        unset($playerHands[0]);

        foreach ($playerHands as $playerHand) {
            $compareResult = $playerHandsOfWinners[0]->compare($playerHand);
            if ($compareResult === CompareHandResultEnum::Higher) {
                $playerHandsOfWinners = [$playerHand];
            } elseif ($compareResult === CompareHandResultEnum::Equal) {
                $playerHandsOfWinners[] = $playerHand;
            }
        }

        $winnersId = [];
        foreach ($playerHandsOfWinners as $winner) {
            $winnersId[] = $winner->playerId;
        }

        $winners = [];
        foreach ($this->players as $player) {
            if (in_array($player->playerId, $winnersId, true)) {
                $winners[] = $player;
            }
        }

        return $winners;
    }

    private function getAllPlayerHands(): array
    {
        $playerHands = [];

        foreach ($this->players as $player) {
            $playerHands[] = $player->getPlayerHand($this->tableCards);
        }

        return $playerHands;
    }
}
