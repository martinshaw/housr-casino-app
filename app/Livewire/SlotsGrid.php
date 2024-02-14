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
        $slotSymbolRepository = app(SlotSymbolRepository::class);
        $latestSpin = $slotSymbolRepository->getCurrentUsersLatestSpin();
        if (is_null($latestSpin)) {
            $this->randomizeSlotBoxSymbols();
            return;
        }

        [
            $this->slotSymbolA,
            $this->slotSymbolB,
            $this->slotSymbolC,
            $this->slotSymbolD,
        ] = $slotSymbolRepository->convertSymbolNamesToSymbols($latestSpin->slot_symbols);
    }

    private function randomizeSlotBoxSymbols() {
        $slotSymbolRepository = app(SlotSymbolRepository::class);
        $slotSymbols = $slotSymbolRepository->getSetOfSlotSymbols(
            withNoneMatching: true,
        );

        [
            $this->slotSymbolA,
            $this->slotSymbolB,
            $this->slotSymbolC,
            $this->slotSymbolD,
        ] = $slotSymbols;
    }

    public function render()
    {
        return view('livewire.slots-grid');
    }
}
