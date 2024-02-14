<?php

namespace App\Livewire;

use App\Repositories\SlotSymbolRepository;
use App\Repositories\UserCreditAllocationRepository;
use Livewire\Component;

class SlotsButtons extends Component
{
    public string | null $errorMessage = null;

    public bool $hasSpun = false;

    public function mount()
    {
        $userCreditAllocationRepository = app(UserCreditAllocationRepository::class);
        $userCreditsCount = $userCreditAllocationRepository->getCurrentUserCreditsCount();
        if ($userCreditsCount === 0) {
            $this->errorMessage = 'You do not have any credits to play.';
        }


        $slotSymbolRepository = app(SlotSymbolRepository::class);
        $this->hasSpun = $slotSymbolRepository->getCurrentUsersLatestSpin() !== null;
    }

    public function cashOut() 
    {
        // TODO: Implement cashOut method
    }

    public function spin() 
    {
        $slotSymbolRepository = app(SlotSymbolRepository::class);
        $nextSpin = $slotSymbolRepository->nextSpin();

        if ($nextSpin === false) {
            $this->errorMessage = 'You do not have enough credits to spin again.';
            return;
        }

        $this->errorMessage = null;

        return redirect()->route('slots');
    }

    public function render()
    {
        return view('livewire.slots-buttons');
    }
}
