<?php

namespace App\Livewire;

use App\Enums\SlotSymbol;
use App\Repositories\SlotSymbolRepository;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class SlotsGrid extends Component
{
    private SlotSymbolRepository $slotSymbolRepository;

    public SlotSymbol $slotSymbolA;
    public SlotSymbol $slotSymbolB;
    public SlotSymbol $slotSymbolC;
    public SlotSymbol $slotSymbolD;

    public function __construct()
    {
        $this->slotSymbolRepository = app(SlotSymbolRepository::class);
    }

    #[On('afterSpin')]
    public function onAfterSpin(): void
    {
        $this->refreshLatestSpinSymbols();
    }

    public function mount(): void
    {
        $this->refreshLatestSpinSymbols();
    }

    private function refreshLatestSpinSymbols(): void
    {
        $latestSpin = $this->slotSymbolRepository->getCurrentUsersLatestSpin();

        [
            $this->slotSymbolA,
            $this->slotSymbolB,
            $this->slotSymbolC,
            $this->slotSymbolD,
        ] = is_null($latestSpin) ?
            $this->slotSymbolRepository->getSetOfSlotSymbols(withNoneMatching: true) :
            $this->slotSymbolRepository->convertSymbolNamesToSymbols($latestSpin->slot_symbols);
    }

    public function render(): View
    {
        return view('livewire.slots-grid');
    }
}
