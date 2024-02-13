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
    public function getSetOfTruelyRandomSlotSymbols(): array
    {
        return [
            $this->getTruelyRandomSlotSymbol(),
            $this->getTruelyRandomSlotSymbol(),
            $this->getTruelyRandomSlotSymbol(),
            $this->getTruelyRandomSlotSymbol(),
        ];
    }

    private function getTruelyRandomSlotSymbol(): SlotSymbol
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