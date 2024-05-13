<?php

namespace App\Game\Poker\PlayerHand;

use App\Game\Card;
use App\Game\Nominal;
use App\Game\Poker\PlayerHand\Combinations\FlashPlayerHand;
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
use RuntimeException;

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
        $nominalsOfCards = [];
        foreach ($arrayOfSevenCards as $card) {
            $nominalsOfCards[] = $card;
        }

        array_multisort($nominalsOfCards, SORT_DESC, $arrayOfSevenCards);
        return $arrayOfSevenCards;
    }

    public function getPlayerHand(): AbstractPlayerHand
    {
        try {
            return $this->getRoyalFlash();
        } catch (RuntimeException $e) {
        }

        try {
            return $this->getFlushStraight();
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
        $cardsFlash = $this->getFlashArray();

        if ($this->doesStreetSpecificExist($cardsFlash, Nominal::Ace, Nominal::King, Nominal::Queen, Nominal::Jack, Nominal::Ten)
        ) {
            return $this->getRoyalFlashSpecific($cardsFlash);
        }

        throw new RuntimeException('');
    }

    private function getFlushStraight(): StraightFlushPlayerHand
    {
        /** @var array<int, Nominal[]> $allPossibleStreets */
        $allPossibleStreets =
            [
                [Nominal::Ace, Nominal::King, Nominal::Queen, Nominal::Jack, Nominal::Ten],
                [Nominal::King, Nominal::Queen, Nominal::Jack, Nominal::Ten, Nominal::Nine],
                [Nominal::Jack, Nominal::Ten, Nominal::Nine, Nominal::Eight, Nominal::Seven],
                [Nominal::Ten, Nominal::Nine, Nominal::Eight, Nominal::Seven, Nominal::Six],
                [Nominal::Nine, Nominal::Eight, Nominal::Seven, Nominal::Six, Nominal::Five],
                [Nominal::Eight, Nominal::Seven, Nominal::Six, Nominal::Five, Nominal::Four],
                [Nominal::Seven, Nominal::Six, Nominal::Five, Nominal::Four, Nominal::Three],
                [Nominal::Six, Nominal::Five, Nominal::Four, Nominal::Three, Nominal::Two],
                [Nominal::Five, Nominal::Four, Nominal::Three, Nominal::Two, Nominal::Ace],
            ];

        foreach ($allPossibleStreets as [$first, $second, $third, $fourth, $fifth]) {
            if ($this->doesStreetSpecificExistInAllCards($first, $second, $third, $fourth, $fifth)
            ) {
                return $this->getStraightFlashSpecific($allPossibleStreets, $first, $second, $third, $fourth, $fifth);
            }
        }

        throw new RuntimeException('');
    }

    private function getFourOfAKind(): FourOfAkindPlayerHand
    {
        $fourOfAKindArray = $this->getSameNominalsFromAllCards(4);
        $otherCards = array_diff($this->arrayOfSevenCards, $fourOfAKindArray);
        $sortedOtherCards = $this->getSortedArrayFromCardsDescending($otherCards);
        $fiveCards = array_merge($fourOfAKindArray, $sortedOtherCards[0]);
        return new FourOfAkindPlayerHand($fiveCards, $this->playerId);
    }

    private function getFullHouse(): FullHousePlayerHand
    {
        $allCards = $this->arrayOfSevenCards;
        $threeCards = $this->getCardsOfSameNominalFromCards($allCards, 3);
        $twoCards = $this->getCardsOfSameNominalFromCards($allCards, 2);
        return new FullHousePlayerHand($threeCards, $twoCards, $this->playerId);
    }

    private function getFlush(): FlashPlayerHand
    {
        $getProbableFlashArray = $this->getFlashArray();
        $arrayOfSameSuit = $this->getSortedArrayFromCardsDescending($getProbableFlashArray);
        array_slice($arrayOfSameSuit, 5);
        return new FlashPlayerHand($arrayOfSameSuit, $this->playerId);
    }

    private function getStraight(): StraightPlayerHand
    {
        /** @var array<int, Nominal[]> $allPossibleStreets */
        $allPossibleStreets =
            [
                [Nominal::Ace, Nominal::King, Nominal::Queen, Nominal::Jack, Nominal::Ten],
                [Nominal::King, Nominal::Queen, Nominal::Jack, Nominal::Ten, Nominal::Nine],
                [Nominal::Jack, Nominal::Ten, Nominal::Nine, Nominal::Eight, Nominal::Seven],
                [Nominal::Ten, Nominal::Nine, Nominal::Eight, Nominal::Seven, Nominal::Six],
                [Nominal::Six, Nominal::Five, Nominal::Four, Nominal::Three, Nominal::Two],
                [Nominal::Five, Nominal::Four, Nominal::Three, Nominal::Two, Nominal::Ace],
            ];

        foreach ($allPossibleStreets as [$first, $second, $third, $fourth, $fifth]) {
            if ($this->doesStreetSpecificExistInAllCards($first, $second, $third, $fourth, $fifth)
            ) {
                return $this->getStraightSpecificFromAllCards($first, $second, $third, $fourth, $fifth);
            }
        }

        throw new RuntimeException('');
    }

    private function getThreeOfAKind(): ThreeOfAKindPlayerHand
    {
        $threeOfAKindArray = $this->getSameNominalsFromAllCards(3);
        $diffArray = array_diff($this->arrayOfSevenCards, $threeOfAKindArray);
        $threeOfAKindArray[] = $diffArray[0];
        $threeOfAKindArray[] = $diffArray[1];
        return new ThreeOfAKindPlayerHand($threeOfAKindArray, $this->playerId);
    }

    private function getTwoPairs(): TwoPairPlayerHand
    {
        $sortedCards = $this->getSortedArrayFromCardsDescending($this->arrayOfSevenCards);
        $highestPair = $this->getPairFromCards($sortedCards);
        $lowestPair = $this->getPairFromCards($sortedCards);
        $highestCard = current($sortedCards);
        return new TwoPairPlayerHand($highestPair, $lowestPair, $highestCard, $this->playerId);
    }

    private function getPairFromCards(array &$originalCardArray): array
    {
        foreach (Nominal::cases() as $nominal) {
            $returnCards = [];

            foreach ($originalCardArray as $originalKey => $card) {
                if ($card->nominal === $nominal) {
                    $returnCards[$originalKey] = $card;
                }
            }

            if (count($returnCards) === 2) {
                foreach ($returnCards as $originalKey => $card) {
                    unset($originalCardArray[$originalKey]);
                }

                return $returnCards;
            }
        }

        throw new RuntimeException('');
    }

    private function getOnePair(): OnePairPlayerHand
    {
        $allCards = $this->getSortedArrayFromCardsDescending($this->arrayOfSevenCards);
        $pair = $this->getCardsOfSameNominalFromCards($allCards, 2);
        $otherThreeCards = array_slice($allCards, 3);
        return new OnePairPlayerHand($pair, $otherThreeCards, $this->playerId);
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


    /** @return Card[] */
    private function getCardsOfSameNominalFromCards(array &$allCards, int $countNeeded): array
    {
        foreach (Nominal::cases() as $nominal) {
            $returnCards = [];

            foreach ($allCards as $originalKey => $card) {
                if ($card->nominal === $nominal) {
                    $returnCards[$originalKey] = $card;
                }
            }

            if (count($returnCards) === $countNeeded) {
                foreach ($returnCards as $originalKey => $card) {
                    unset($allCards[$originalKey]);
                    return $returnCards;
                }
            }
        }

        throw new RuntimeException('');
    }

    private function getSortedArrayFromCardsDescending(array $cards): array
    {
        $return = [];

        $allNominals = Nominal::cases();
        foreach (array_reverse($allNominals) as $nominal) {
            foreach ($cards as $card) {
                if ($card->nominal === $nominal) {
                    $return[] = $card;
                }
            }
        }

        return $return;
    }

    private function doesStreetSpecificExist(array $cards, Nominal $first, Nominal $second, Nominal $third, Nominal $fourth, Nominal $fifth): bool
    {
        return (
            $this->isNominalPresent($first, $cards)
            && $this->isNominalPresent($second, $cards)
            && $this->isNominalPresent($third, $cards)
            && $this->isNominalPresent($fourth, $cards)
            && $this->isNominalPresent($fifth, $cards)
        );
    }

    private function doesStreetSpecificExistInAllCards(Nominal $first, Nominal $second, Nominal $third, Nominal $fourth, Nominal $fifth): bool
    {
        return (
            $this->isNominalPresentInAllCards($first)
            && $this->isNominalPresentInAllCards($second)
            && $this->isNominalPresentInAllCards($third)
            && $this->isNominalPresentInAllCards($fourth)
            && $this->isNominalPresentInAllCards($fifth)
        );
    }

    private function getRoyalFlashSpecific(array $cards): RoyalFlashPlayerHand
    {
        return new RoyalFlashPlayerHand (
            [
                $this->getNominalFromCards(Nominal::Ace, $cards),
                $this->getNominalFromCards(Nominal::King, $cards),
                $this->getNominalFromCards(Nominal::Queen, $cards),
                $this->getNominalFromCards(Nominal::Jack, $cards),
                $this->getNominalFromCards(Nominal::Ten, $cards),
            ],
            $this->playerId);
    }

    private function getStraightFlashSpecific(array $cards, Nominal $first, Nominal $second, Nominal $third, Nominal $fourth, Nominal $fifth): StraightFlushPlayerHand
    {
        return new StraightFlushPlayerHand (
            [
                $this->getNominalFromCards($first, $cards),
                $this->getNominalFromCards($second, $cards),
                $this->getNominalFromCards($third, $cards),
                $this->getNominalFromCards($fourth, $cards),
                $this->getNominalFromCards($fifth, $cards),
            ],
            $this->playerId);
    }

    private function getStraightSpecificFromAllCards(Nominal $first, Nominal $second, Nominal $third, Nominal $fourth, Nominal $fifth): StraightPlayerHand
    {
        return new StraightPlayerHand (
            [
                $this->getNominalFromAllCards($first),
                $this->getNominalFromAllCards($second),
                $this->getNominalFromAllCards($third),
                $this->getNominalFromAllCards($fourth),
                $this->getNominalFromAllCards($fifth),
            ],
            $this->playerId);
    }

    /** @return Card[] */
    private function getFlashArray(): array
    {
        foreach (Suit::cases() as $suit) {
            $arraySameSuit = [];
            foreach ($this->arrayOfSevenCards as $card) {
                if ($card->suit === $suit) {
                    $arraySameSuit[] = $card;
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
                    $arraySameSuit[] = $card;
                }
            }
            if (count($arraySameSuit) === $countNumber) {
                return $arraySameSuit;
            }
        }
        throw new RuntimeException('');
    }

    private function getSameNominalsFromAllCards($countNumber): array
    {
        foreach (Nominal::cases() as $nominal) {
            $arraySameSuit = [];

            foreach ($this->arrayOfSevenCards as $card) {
                if ($card->nominal === $nominal) {
                    $arraySameSuit[] = $card;
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
        return $this->getNominalFromCards($nominal, $this->arrayOfSevenCards);
    }

    /** @param Card[] $cards */
    private function getNominalFromCards(Nominal $nominal, array $cards): Card
    {
        foreach ($cards as $card) {
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
