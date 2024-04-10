<?php

namespace App\Game\Poker;

use App\Game\Deck;
use Illuminate\Http\Request;

class Poker
{

    /**
     * @param Player[] $players
     */
    public function __construct(
        public Deck           $deck,
        public readonly array $players,
        public int            $pot = 0,
        public array          $tableCards = [],
    )
    {
    }

    public static function createNewGame(): Poker
    {
        $deck = Deck::fullShuffledDeck();
        $players = self::getNewPlayers($deck);
        return new self($deck, $players);
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

    public function bettingAtPreFlop($roundBet): void
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

}
