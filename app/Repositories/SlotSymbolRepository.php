<?php

namespace App\Repositories;

use App\Models\UserSlotsSpin;
use Illuminate\Support\Facades\Auth;

enum SlotSymbol: string {
    case Cherry = '🍒';
    case Lemon = '🍋';
    case Orange = '🍊';
    case Watermelon = '🍉';
};

class SlotSymbolRepository
{
    public function getCurrentUsersLatestSpin() : UserSlotsSpin | null
    {
        return Auth::user()->slotsSpins()->latest()->first();
    }

    private function slotSymbolsWin(array $slotSymbols): int
    {
        $uniqueSlotSymbolsCount = count(array_unique(array_map(fn ($symbol) => $symbol->name, $slotSymbols)));
        
        if ($uniqueSlotSymbolsCount !== 1) return 0;

        $slotSymbol = $slotSymbols[0];

        if ($slotSymbol === SlotSymbol::Cherry) return config('casino.credit_allocation_quantity.gain_on_win_with_cherry', 0);
        if ($slotSymbol === SlotSymbol::Lemon) return config('casino.credit_allocation_quantity.gain_on_win_with_lemon', 0);
        if ($slotSymbol === SlotSymbol::Orange) return config('casino.credit_allocation_quantity.gain_on_win_with_orange', 0);
        if ($slotSymbol === SlotSymbol::Watermelon) return config('casino.credit_allocation_quantity.gain_on_win_with_watermelon', 0);
        
        return 0;
    }

    public function nextSpin(): UserSlotsSpin | false
    {
        $userCreditAllocationRepository = app(UserCreditAllocationRepository::class);

        $creditsQuantityBet = $userCreditAllocationRepository->chargeCredits(
            config('casino.credit_allocation_quantity.cost_of_spin', 0),
        );

        if ($creditsQuantityBet === false) return false;

        $currentUserCreditsCount = $userCreditAllocationRepository->getCurrentUserCreditsCount();

        $previousWinsCount = UserSlotsSpin::query()
            ->where('user_id', Auth::id())
            ->where('credits_quantity_won', '>', 0)
            ->count();
        
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
        $slotSymbols = [
            SlotSymbol::Cherry,
            SlotSymbol::Lemon,
            SlotSymbol::Orange,
            SlotSymbol::Watermelon,
        ];

        return $slotSymbols[array_rand($slotSymbols)];
    }
}