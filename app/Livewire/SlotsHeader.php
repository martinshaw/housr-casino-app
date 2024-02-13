<?php

namespace App\Livewire;

use App\Repositories\UserCreditAllocationRepository;
use Livewire\Component;

class SlotsHeader extends Component
{
    public int $userCreditsCount = 0;

    public function mount()
    {
        $this->userCreditsCount = app(UserCreditAllocationRepository::class)->getCurrentUserCreditsCount();
    }

    public function render()
    {
        return view('livewire.slots-header');
    }
}
