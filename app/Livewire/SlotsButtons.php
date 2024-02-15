<?php

namespace App\Livewire;

use App\Models\UserSlotsSpin;
use App\Repositories\SlotSymbolRepository;
use App\Repositories\UserCreditAllocationRepository;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Str;

class SlotsButtons extends Component
{
    private UserCreditAllocationRepository $userCreditAllocationRepository;
    private SlotSymbolRepository $slotSymbolRepository;

    public int $userCreditsCount = 0;

    public string | null $statusMessage = null;

    public UserSlotsSpin | null $latestSpin = null;

    public function __construct()
    {
        $this->userCreditAllocationRepository = app(UserCreditAllocationRepository::class);
        $this->slotSymbolRepository = app(SlotSymbolRepository::class);
    }
    
    #[Computed]
    public function hasSpun(): bool
    {
        return $this->latestSpin !== null;
    }

    #[Computed]
    public function canSpin(): bool
    {
        return $this->userCreditsCount > 0;
    }

    #[Computed]
    public function canCashOut(): bool
    {
        return $this->userCreditsCount > 0 && $this->hasSpun;
    }

    #[On('cashOut')]
    public function onCashOut()
    {
        // TODO: Implement cashOut method
    }

    #[On('spin')]
    public function onSpin()
    {
        $this->refreshCheckForSufficientCredits();

        $latestSpin = $this->slotSymbolRepository->nextSpin();
        $this->latestSpin = $latestSpin === false ? null : $latestSpin;

        $this->reset('statusMessage');

        if ($this->latestSpin === false) {
            $this->statusMessage = 'You do not have enough credits to spin again.';
            return;
        }

        $this->dispatch('afterSpin');
    }

    #[On('afterSpin')]
    public function onAfterSpin(): void
    {
        $this->reset([
            'userCreditsCount',
            'statusMessage',
        ]);

        $this->refreshCheckForSufficientCredits();
        $this->refreshCheckForWinningSpin();
    }

    public function mount(): void
    {
        $this->refreshCheckForSufficientCredits();
        $this->refreshCheckForWinningSpin();
    }

    private function refreshCheckForSufficientCredits(): void
    {
        $this->userCreditsCount = $this->userCreditAllocationRepository->getCurrentUserCreditsCount();
        if ($this->userCreditsCount === 0) {
            $this->statusMessage = 'You do not have any credits to play.';
        }
    }

    private function refreshCheckForWinningSpin(): void
    {
        if ($this->latestSpin === null) return;

        $winningInfo = $this->slotSymbolRepository->determineWinningSymbolFromUserSlotsSpin($this->latestSpin);
        if ($winningInfo !== false) {
            [$winningSymbol, $winnings] = $winningInfo;
            $winningSymbolName = Str::plural(implode(' ', Str::ucsplit($winningSymbol->name)));

            $this->statusMessage = "Jackpot!!! You won {$winnings} credits with {$winningSymbolName}!";
        }
    }


    public function render(): View
    {
        return view('livewire.slots-buttons');
    }
}
