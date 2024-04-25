<?php

namespace App\Game\Poker\PlayerHand;

use App\Game\Card;
use App\Game\Nominal;
use App\Game\Poker\PlayerHand\Combinations\HighCardPlayerHand;
use App\Game\Poker\PlayerHand\Combinations\RoyalFlashPlayerHand;
use App\Game\Poker\PlayerHand\Combinations\StraightPlayerHand;
use App\Game\Suit;
use http\Exception\RuntimeException;

class PlayerHandFactory
{

    /**
     * @param Card[] $arrayOfSevenCards
     * @param int $playerId
     */
    public function __construct(
        private array        $arrayOfSevenCards,
        private readonly int $playerId
    )
    {
    }

    private function getArrayOfSevenCards(): array
    {
        $arrayOfSevenCards = $this->arrayOfSevenCards;
        foreach ($arrayOfSevenCards as $card) {
            $sortedArray[] = $card->nominal;
        }
        array_multisort($sortedArray, SORT_DESC, $arrayOfSevenCards);
        return $arrayOfSevenCards;
    }

    public function getPlayerHand(): AbstractPlayerHand
    {
        try {
            return $this->getRoyalFlash();
        } catch (RuntimeException $e) {
        }

        try {
            return $this->getStraight();
        } catch (RuntimeException $e) {
        }

        return HighCardPlayerHand::fromSevenCards($this->getArrayOfSevenCards(), $this->playerId);
    }


    private function getRoyalFlash(): RoyalFlashPlayerHand
    {
        if ($this->isNominalPresentInAllCards(Nominal::Ace)) {
            $cardsFlash = $this->getFlashArray();
            if (
                $this->isNominalPresent(Nominal::King, $cardsFlash)
                && $this->isNominalPresent(Nominal::Queen, $cardsFlash)
                && $this->isNominalPresent(Nominal::Jack, $cardsFlash)
                && $this->isNominalPresent(Nominal::Ten, $cardsFlash)
            ) {

                return new RoyalFlashPlayerHand();
            }
        }
        throw new RuntimeException('');
    }

    private function getStraight(): StraightPlayerHand
    {
        if (
            $this->isNominalPresentInAllCards(Nominal::Ace)
            && $this->isNominalPresentInAllCards(Nominal::Two)
            && $this->isNominalPresentInAllCards(Nominal::Three)
            && $this->isNominalPresentInAllCards(Nominal::Four)
            && $this->isNominalPresentInAllCards(Nominal::Five)
        ) {
            {
                $fiveCards = [
                    $this->getNominalFromAllCards(Nominal::Ace),
                    $this->getNominalFromAllCards(Nominal::Two),
                    $this->getNominalFromAllCards(Nominal::Three),
                    $this->getNominalFromAllCards(Nominal::Four),
                    $this->getNominalFromAllCards(Nominal::Five),
                ];
                return new StraightPlayerHand($fiveCards, $this->playerId);
            }
        }

        if (
            $this->isNominalPresentInAllCards(Nominal::Ace)
            && $this->isNominalPresentInAllCards(Nominal::King)
            && $this->isNominalPresentInAllCards(Nominal::Queen)
            && $this->isNominalPresentInAllCards(Nominal::Jack)
            && $this->isNominalPresentInAllCards(Nominal::Ten)
        ) {
            $fiveCards = [
                $this->getNominalFromAllCards(Nominal::Ace),
                $this->getNominalFromAllCards(Nominal::King),
                $this->getNominalFromAllCards(Nominal::Queen),
                $this->getNominalFromAllCards(Nominal::Jack),
                $this->getNominalFromAllCards(Nominal::Ten),
            ];
            return new StraightPlayerHand ($fiveCards, $this->playerId);
        }
        throw new RuntimeException('');
    }

    private function getHighestCard(): HighCardPlayerHand
    {
        if (
            $this->isNominalPresentInAllCards(Nominal::Ace)

        ) {

            $fiveCards = [
                $this->getNominalFromAllCards(Nominal::Ace),
                $this->getNominalFromAllCards(Nominal::King),
                $this->getNominalFromAllCards(Nominal::Queen),
                $this->getNominalFromAllCards(Nominal::Jack),
                $this->getNominalFromAllCards(Nominal::Ten),
            ];
            return new HighCardPlayerHand ($fiveCards, $this->playerId);
        }
        throw new RuntimeException('');
    }


    //middle methods
    private function getFlashArray(): array
    {
        foreach (Suit::cases() as $suit) {
            $arraySameSuit = [];
            foreach ($this->arrayOfSevenCards as $card) {
                if ($card->suit === $suit) {
                    $arraySameSuit[] = $card->suit;
                }
            }
            if (count($arraySameSuit) >= 5) {
                return $arraySameSuit;
            }
        }
        throw new RuntimeException('');
    }


//common methods
    private function isNominalPresentInAllCards(Nominal $nominal): bool
    {
        return $this->isNominalPresent($nominal, $this->arrayOfSevenCards);
    }

    private function isNominalPresent(Nominal $nominal, array $cards): bool
    {
        foreach ($cards as $card) {
            if ($card->nominal === $nominal) {
                return true;
            }
        }
        return false;
    }

    private function getNominalFromAllCards(Nominal $nominal): Card
    {
        foreach ($this->arrayOfSevenCards as $card) {
            if ($card->nominal === $nominal) {
                return $card;
            }
        }
        throw new RuntimeException('');
    }

    private function isSuitPresentInAllCards(Suit $suit): bool
    {
        return $this->isSuitPresent($suit, $this->arrayOfSevenCards);
    }

    private function isSuitPresent(Suit $suit, array $cards): bool
    {
        foreach ($cards as $card) {
            if ($card->suit === $suit) {
                return true;
            }
        }
        return false;
    }

    private function getSuitFromAllCards(Suit $suit): Card
    {
        foreach ($this->arrayOfSevenCards as $card) {
            if ($card->suit === $suit) {
                return $card;
            }
        }
        throw new RuntimeException('');
    }

}
