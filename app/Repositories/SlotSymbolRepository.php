<?php

namespace App\Repositories;

enum SlotSymbol: string {
    case Cherry = '🍒';
    case Lemon = '🍋';
    case Orange = '🍊';
    case Watermelon = '🍉';
};

class SlotSymbolRepository
{
    public function getSetOfSlotSymbols(
        SlotSymbol | null $biasedTowardSymbol = null,
        float $biasedTowardAmount = 0,
        bool $withNoneMatching = false
    ): array
    {
        $symbols = [
            $this->getRandomSlotSymbol(
                $biasedTowardSymbol,
                $biasedTowardAmount,
            ),
            $this->getRandomSlotSymbol(
                $biasedTowardSymbol,
                $biasedTowardAmount,
            ),
            $this->getRandomSlotSymbol(
                $biasedTowardSymbol,
                $biasedTowardAmount,
            ),
            $this->getRandomSlotSymbol(
                $biasedTowardSymbol,
                $biasedTowardAmount,
            ),
        ];

        $symbolsAreNotUnique = count(array_unique(array_map(fn ($symbol) => $symbol->name, $symbols))) !== 4;
        if ($withNoneMatching && $symbolsAreNotUnique) 
            return $this->getSetOfSlotSymbols(
                $biasedTowardSymbol,
                $biasedTowardAmount,
                $withNoneMatching,
            );

        return $symbols;
    }

    private function getRandomSlotSymbol(
        SlotSymbol | null $biasedTowardSymbol = null,
        float $biasedTowardAmount = 0,
    ): SlotSymbol
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