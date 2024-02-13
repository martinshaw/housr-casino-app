<?php

namespace App\Repositories;

use App\Models\UserSlotsSpin;

enum SlotSymbol: string {
    case Cherry = '🍒';
    case Lemon = '🍋';
    case Orange = '🍊';
    case Watermelon = '🍉';
};

class SlotSymbolRepository
{
    public function nextSpin(): UserSlotsSpin | false
    {
        $userCreditAllocationRepository = app(UserCreditAllocationRepository::class);

        $creditsQuantityBet = $userCreditAllocationRepository->chargeCredits(
            config('casino.credit_allocation_quantity.cost_of_spin', 0),
        );

        if ($creditsQuantityBet === false) return false;

        $currentUserCreditsCount = $userCreditAllocationRepository->getCurrentUserCreditsCount();
        
        $slotSymbols = null;

        if ($currentUserCreditsCount < 40) $slotSymbols = $this->getSetOfSlotSymbols();

        else if ($currentUserCreditsCount >= 40 && $currentUserCreditsCount < 60) {
            //
        }
    }

    public function getSetOfSlotSymbols(
        float $biasTowardMatching = 0,
        bool $withNoneMatching = false
    ): array
    {
        $matchableSymbol = $this->getRandomSlotSymbol();
        
        $chanceSymbolShouldMatch = fn () => mt_rand(0, 100) <= ($biasTowardMatching * 100);

        $symbols = [
            $chanceSymbolShouldMatch() ? $matchableSymbol : $this->getRandomSlotSymbol(),
            $chanceSymbolShouldMatch() ? $matchableSymbol : $this->getRandomSlotSymbol(),
            $chanceSymbolShouldMatch() ? $matchableSymbol : $this->getRandomSlotSymbol(),
            $chanceSymbolShouldMatch() ? $matchableSymbol : $this->getRandomSlotSymbol(),
        ];

        $symbolsAreNotUnique = count(array_unique(array_map(fn ($symbol) => $symbol->name, $symbols))) !== 4;
        if ($withNoneMatching && $symbolsAreNotUnique) 
            return $this->getSetOfSlotSymbols(
                $biasTowardMatching,
                $withNoneMatching,
            );

        return $symbols;
    }

    private function getRandomSlotSymbol(): SlotSymbol
    {
        $slotSymbols = [
            SlotSymbol::Cherry,
            SlotSymbol::Lemon,
            SlotSymbol::Orange,
            SlotSymbol::Watermelon,
        ];

        return $slotSymbols[array_rand($slotSymbols)];
    }
}