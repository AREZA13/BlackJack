<?php

namespace App\Game\Poker\PlayerHand;

use App\Game\Card;
use App\Game\Nominal;
use App\Game\Poker\PlayerHand\Combinations\FourOfAkindPlayerHand;
use App\Game\Poker\PlayerHand\Combinations\FullHousePlayerHand;
use App\Game\Poker\PlayerHand\Combinations\HighCardPlayerHand;
use App\Game\Poker\PlayerHand\Combinations\OnePairPlayerHand;
use App\Game\Poker\PlayerHand\Combinations\RoyalFlashPlayerHand;
use App\Game\Poker\PlayerHand\Combinations\StraightFlushPlayerHand;
use App\Game\Poker\PlayerHand\Combinations\StraightPlayerHand;
use App\Game\Poker\PlayerHand\Combinations\ThreeOfAKindPlayerHand;
use App\Game\Poker\PlayerHand\Combinations\TwoPairPlayerHand;
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
            return $this->getStraightFlush();
        } catch (RuntimeException $e) {
        }

        try {
            return $this->getFourOfAKind();
        } catch (RuntimeException $e) {
        }

        try {
            return $this->getFullHouse();
        } catch (RuntimeException $e) {
        }

        try {
            return $this->getFlush();
        } catch (RuntimeException $e) {
        }

        try {
            return $this->getStraight();
        } catch (RuntimeException $e) {
        }

        try {
            return $this->getThreeOfAKind();
        } catch (RuntimeException $e) {
        }

        try {
            return $this->getTwoPairs();
        } catch (RuntimeException $e) {
        }

        try {
            return $this->getOnePair();
        } catch (RuntimeException $e) {
        }

        return $this->getHighestCard();
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

    private function getStraightFlush(): StraightFlushPlayerHand
    {

    }

    private function getFourOfAKind(): FourOfAkindPlayerHand
    {
        $fourOfAKindArray = $this->countForNominal(4);
        $diffArray = array_diff($this->arrayOfSevenCards, $fourOfAKindArray);
        $fourOfAKindArray[] = $diffArray[0];
        return new FourOfAkindPlayerHand($fourOfAKindArray, $this->playerId);

    }

    private function getFullHouse(): FullHousePlayerHand
    {
        /**
         * @var Card $card
         */
        $arrayOfNumbers = [];
        foreach ($this->arrayOfSevenCards as $card->nominal) {
            $arrayOfNumbers[] = $card->nominal;
        }
        $counts = array_count_values($arrayOfNumbers);
        $keys = array_keys($counts);
        $triple = $keys[0];
        $pair = $keys[1];

        $full_house = [];
        if ($counts[$triple] >= 3 && $counts[$pair] >= 2) {
            array_push($full_house, $triple, $triple, $triple, $pair, $pair);
        }

        return new FullHousePlayerHand($full_house, $this->playerId);
    }

    private function getFlush(): FlashPlayerHand
    {
        $getProbableFlashArray = $this->getFlashArray();
        $arrayOfSameSuit = $this->getArrayOfSevenCards($getProbableFlashArray);
        array_pop($arrayOfSameSuit);
        array_pop($arrayOfSameSuit);
        return new FlashPlayerHand($arrayOfSameSuit, $this->playerId);
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

    private function getThreeOfAKind(): ThreeOfAKindPlayerHand
    {
        $threeOfAKindArray = $this->countForNominal(3);
        $diffArray = array_diff($this->arrayOfSevenCards, $threeOfAKindArray);
        $threeOfAKindArray[] = $diffArray[0];
        $threeOfAKindArray[] = $diffArray[1];
        return new ThreeOfAKindPlayerHand($threeOfAKindArray, $this->playerId);
    }

    private function getTwoPairs(): TwoPairPlayerHand
    {
        /**
         * @var Card $card
         */
        $arrayOfNumbers = [];
        foreach ($this->arrayOfSevenCards as $card->nominal) {
            $arrayOfNumbers[] = $card->nominal;
        }
        rsort($arrayOfNumbers);
        $pairs = [];

        for ($i = 0; $i < count($arrayOfNumbers) - 1; $i++) {
            if ($arrayOfNumbers[$i] == $arrayOfNumbers[$i + 1]) {
                $pairs[] = $arrayOfNumbers[$i];
                $i++;
            }
        }

        $highest_pairs = [];
        if (count($pairs) >= 2) {
            $highest_pairs = array_slice($pairs, 0, 2);
        }

        return new TwoPairPlayerHand($highest_pairs, $this->playerId);

    }

    private function getOnePair(): OnePairPlayerHand
    {
        /**
         * @var Card $card
         */
        $arrayOfNumbers = [];
        foreach ($this->arrayOfSevenCards as $card->nominal) {
            $arrayOfNumbers[] = $card->nominal;
        }
        rsort($arrayOfNumbers);
        $pair = [];

        for ($i = 0; $i < count($arrayOfNumbers) - 1; $i++) {
            if ($arrayOfNumbers[$i] == $arrayOfNumbers[$i + 1]) {
                $pair[] = $arrayOfNumbers[$i];
                $i++;
            }
        }

        $highest_pair = [];
        if (count($pair) >= 1) {
            $highest_pair = array_slice($pair, 0, 1);
        }

        return new OnePairPlayerHand($highest_pair, $this->playerId);

    }

    private function getHighestCard(): HighCardPlayerHand
    {
        /**
         * @var Nominal $nominal
         */
        $arrayOfNumbers = [];
        foreach ($this->arrayOfSevenCards as $card) {
            $arrayOfNumbers[] = $card->nominal->getAsNumber();
        }
        $max_number = max($arrayOfNumbers);
        array_pop($arrayOfNumbers);
        array_pop($arrayOfNumbers);
        unset($arrayOfNumbers[0]);
        array_unshift($arrayOfNumbers, $max_number);


        return new HighCardPlayerHand($arrayOfNumbers, $this->playerId);
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
    private function countForSuit($countNumber): array
    {
        foreach (Suit::cases() as $suit) {
            $arraySameSuit = [];
            foreach ($this->arrayOfSevenCards as $card) {
                if ($card->suit === $suit) {
                    $arraySameSuit[] = $card->suit;
                }
            }
            if (count($arraySameSuit) === $countNumber) {
                return $arraySameSuit;
            }
        }
        throw new RuntimeException('');
    }

    private function countForNominal($countNumber): array
    {
        foreach (Nominal::cases() as $nominal) {
            $arraySameSuit = [];
            foreach ($this->arrayOfSevenCards as $card) {
                if ($card->nominal === $nominal) {
                    $arraySameSuit[] = $card->suit;
                }
            }
            if (count($arraySameSuit) === $countNumber) {
                return $arraySameSuit;
            }
        }
        throw new RuntimeException('');
    }

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
