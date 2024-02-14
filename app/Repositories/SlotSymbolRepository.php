<?php

namespace App\Repositories;

use App\Enums\SlotSymbol;
use App\Models\UserSlotsSpin;
use Illuminate\Support\Facades\Auth;

class SlotSymbolRepository
{
    public function convertSymbolNamesToSymbols(array $symbolNames): array 
    {
        return array_map(
            fn ($symbolName) => $this->convertSymbolNameToSymbol($symbolName),
            $symbolNames
        );    
    }

    private function convertSymbolNameToSymbol(string $symbolName): SlotSymbol
    {
        foreach (SlotSymbol::cases() as $slotSymbol) {
            if ($slotSymbol->value === $symbolName) return $slotSymbol;
        }
    }

    public function getCurrentUsersLatestSpin() : UserSlotsSpin | null
    {
        return Auth::user()->slotsSpins()->latest()->first();
    }

    private function slotSymbolsWin(array $slotSymbols): int
    {
        $uniqueSlotSymbolsCount = count(array_unique(array_map(fn ($symbol) => $symbol->name, $slotSymbols)));
        if ($uniqueSlotSymbolsCount !== 1) return 0;

        $slotSymbol = $slotSymbols[0];

        return config('casino.credit_allocation_quantity.gain_on_win_with.' . $slotSymbol->name, 0);
    }

    public function nextSpin(): UserSlotsSpin | false
    {
        $userCreditAllocationRepository = app(UserCreditAllocationRepository::class);

        $creditsQuantityBet = $userCreditAllocationRepository->chargeCredits(
            config('casino.credit_allocation_quantity.cost_of_spin', 0),
        );

        if ($creditsQuantityBet === false) return false;

        $currentUserCreditsCount = $userCreditAllocationRepository->getCurrentUserCreditsCount();

        $previousWinsCount = Auth::user()?->slotsSpins()?->withWinnings()?->count() ?? 0;
        
        $slotSymbols = null;

        if ($currentUserCreditsCount < 40) $slotSymbols = $this->getSetOfSlotSymbols();

        else if ($currentUserCreditsCount >= 40 && $currentUserCreditsCount < 60) {
            $chance = $previousWinsCount * 0.3;
            $slotSymbols = $this->getSetOfSlotSymbols(biasAgainstMatching: $chance);
            if ($this->slotSymbolsWin($slotSymbols) > 0) $slotSymbols = $this->getSetOfSlotSymbols(biasAgainstMatching: $chance);
        }

        else if ($currentUserCreditsCount >= 60) {                
            $chance = $previousWinsCount * 0.6;
            $slotSymbols = $this->getSetOfSlotSymbols(biasAgainstMatching: $chance);
            if ($this->slotSymbolsWin($slotSymbols) > 0) $slotSymbols = $this->getSetOfSlotSymbols(biasAgainstMatching: $chance);
        }

        $creditsQuantityWon = $this->slotSymbolsWin($slotSymbols);

        $userSlotsSpin = Auth::user()->slotsSpins()->create([
            'slot_symbols' => $slotSymbols,
            'credits_quantity_won' => $creditsQuantityWon,
            'credits_quantity_bet' => $creditsQuantityBet,
        ]);

        if ($creditsQuantityWon > 0) $userCreditAllocationRepository->depositCredits($creditsQuantityWon);

        return $userSlotsSpin;
    }

    public function getSetOfSlotSymbols(
        float $biasAgainstMatching = 0,
        bool $withNoneMatching = false
    ): array
    {
        $symbols = [
            $this->getRandomSlotSymbol(),
            $this->getRandomSlotSymbol(),
            $this->getRandomSlotSymbol(),
            $this->getRandomSlotSymbol(),
        ];
        
        $chanceSymbolShouldNotMatch = mt_rand(0, 100) <= ($biasAgainstMatching * 100);
        
        $symbolsAreNotUnique = count(array_unique(array_map(fn ($symbol) => $symbol->name, $symbols))) !== 4;
        if (($withNoneMatching || $chanceSymbolShouldNotMatch) && $symbolsAreNotUnique) 
            return $this->getSetOfSlotSymbols(
                $biasAgainstMatching,
                true
            );

        return $symbols;
    }

    private function getRandomSlotSymbol(): SlotSymbol
    {
        $slotSymbols = SlotSymbol::cases();
        return $slotSymbols[array_rand($slotSymbols)];
    }
}