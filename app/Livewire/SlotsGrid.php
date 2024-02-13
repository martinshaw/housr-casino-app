<?php

namespace App\Livewire;

use App\Repositories\SlotSymbol;
use App\Repositories\SlotSymbolRepository;
use Livewire\Component;

class SlotsGrid extends Component
{
    public SlotSymbol $slotSymbolA;
    public SlotSymbol $slotSymbolB;
    public SlotSymbol $slotSymbolC;
    public SlotSymbol $slotSymbolD;

    public function mount()
    {
        $latestSpin = app(SlotSymbolRepository::class)->getCurrentUsersLatestSpin();
        if (is_null($latestSpin)) $this->randomizeSlotBoxSymbols();

        $this->slotSymbolA = $this->convertSymbolNameToSymbol($latestSpin->slot_symbols[0]);
        $this->slotSymbolB = $this->convertSymbolNameToSymbol($latestSpin->slot_symbols[1]);
        $this->slotSymbolC = $this->convertSymbolNameToSymbol($latestSpin->slot_symbols[2]);
        $this->slotSymbolD = $this->convertSymbolNameToSymbol($latestSpin->slot_symbols[3]);
    }

    private function convertSymbolNameToSymbol(string $symbolName): SlotSymbol
    {
        switch ($symbolName) {
            case '🍒': return SlotSymbol::Cherry;
            case '🍋': return SlotSymbol::Lemon;
            case '🍊': return SlotSymbol::Orange;
            case '🍉': return SlotSymbol::Watermelon;
        }
    }

    private function randomizeSlotBoxSymbols() {
        $slotSymbolRepository = app(SlotSymbolRepository::class);
        $slotSymbols = $slotSymbolRepository->getSetOfSlotSymbols(
            withNoneMatching: true,
        );

        $this->slotSymbolA = $slotSymbols[0];
        $this->slotSymbolB = $slotSymbols[1];
        $this->slotSymbolC = $slotSymbols[2];
        $this->slotSymbolD = $slotSymbols[3];
    }

    public function render()
    {
        return view('livewire.slots-grid');
    }
}
