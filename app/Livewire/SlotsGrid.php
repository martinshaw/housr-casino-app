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
        $this->randomizeSlotBoxSymbols();
    }

    private function randomizeSlotBoxSymbols() {
        $slotSymbolRepository = app(SlotSymbolRepository::class);
        $slotSymbols = $slotSymbolRepository->getSetOfTruelyRandomSlotSymbols();

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
