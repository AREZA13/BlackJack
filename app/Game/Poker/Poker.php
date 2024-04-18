<?php

namespace App\Game\Poker;

use App\Game\Deck;

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
}
