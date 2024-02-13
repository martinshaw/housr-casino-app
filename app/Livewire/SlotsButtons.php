<?php

namespace App\Livewire;

use App\Repositories\SlotSymbolRepository;
use App\Repositories\UserCreditAllocationRepository;
use Livewire\Component;

class SlotsButtons extends Component
{
    public string | null $errorMessage = null;

    public function mount()
    {
        $userCreditsCount = app(UserCreditAllocationRepository::class)->getCurrentUserCreditsCount();
        if ($userCreditsCount === 0) {
            $this->errorMessage = 'You do not have any credits to play.';
        }
    }

    public function cashOut() 
    {
        //
    }

    public function spin() 
    {
        $nextSpin = app(SlotSymbolRepository::class)->nextSpin();

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
