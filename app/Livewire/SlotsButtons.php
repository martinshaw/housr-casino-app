<?php

namespace App\Livewire;

use App\Repositories\SlotSymbolRepository;
use App\Repositories\UserCreditAllocationRepository;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class SlotsButtons extends Component
{
    private UserCreditAllocationRepository $userCreditAllocationRepository;
    private SlotSymbolRepository $slotSymbolRepository;

    public string | null $statusMessage = null;

    public function __construct()
    {
        $this->userCreditAllocationRepository = app(UserCreditAllocationRepository::class);
        $this->slotSymbolRepository = app(SlotSymbolRepository::class);
    }
    
    #[Computed]
    public function hasSpun(): bool
    {
        return $this->slotSymbolRepository->getCurrentUsersLatestSpin() !== null;
    }

    #[Computed]
    public function canSpin(): bool
    {
        return $this->statusMessage === null;
    }

    #[Computed]
    public function canCashOut(): bool
    {
        return $this->statusMessage === null && $this->hasSpun;
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

        $nextSpin = $this->slotSymbolRepository->nextSpin();

        if ($nextSpin === false) {
            $this->statusMessage = 'You do not have enough credits to spin again.';
            return;
        }

        $this->dispatch('afterSpin');
    }

    public function mount(): void
    {
        $this->refreshCheckForSufficientCredits();
    }

    private function refreshCheckForSufficientCredits(): void
    {
        $userCreditsCount = $this->userCreditAllocationRepository->getCurrentUserCreditsCount();
        if ($userCreditsCount === 0) {
            $this->statusMessage = 'You do not have any credits to play.';
            return;
        }

        $this->statusMessage = null;
    }

    public function render(): View
    {
        return view('livewire.slots-buttons');
    }
}
