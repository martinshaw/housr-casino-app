<?php

namespace App\Livewire\Pages;

use App\Repositories\SlotSymbolRepository;
use App\Repositories\UserCreditAllocationRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Slots extends Component
{
    public string | null $statusMessage = null;

    private UserCreditAllocationRepository $userCreditAllocationRepository;
    private SlotSymbolRepository $slotSymbolRepository;

    public function mount(
        UserCreditAllocationRepository $userCreditAllocationRepository, 
        SlotSymbolRepository $slotSymbolRepository
    )
    {
        $this->userCreditAllocationRepository = $userCreditAllocationRepository;
        $this->slotSymbolRepository = $slotSymbolRepository;
    }

    #[On('cashOut')]
    public function cashOut()   
    {
        // TODO: Implement cashOut method
    }

    #[On('spin')]
    public function spin() 
    {
        $userCreditsCount = $this->userCreditAllocationRepository->getCurrentUserCreditsCount();
        if ($userCreditsCount === 0) {
            $this->statusMessage = 'You do not have any credits to play.';
        }

        $nextSpin = $this->slotSymbolRepository->nextSpin();

        if ($nextSpin === false) {
            $this->statusMessage = 'You do not have enough credits to spin again.';
            return;
        }

        $this->statusMessage = null;

        // return redirect()->route('slots');
    }

    public function render()
    {
        return view('livewire.pages.slots');
    }
}
