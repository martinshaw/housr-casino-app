<?php

namespace App\Livewire;

use App\Repositories\UserCreditAllocationRepository;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class SlotsCashoutModal extends Component
{
    private UserCreditAllocationRepository $userCreditAllocationRepository;

    #[Computed]
    public function userCreditsCount(): int
    {
        return $this->userCreditAllocationRepository->getCurrentUserCreditsCount();
    }

    public function __construct()
    {
        $this->userCreditAllocationRepository = app(UserCreditAllocationRepository::class);
    }

    public function navigateToCashout()
    {
        return redirect()->route('slots.cashout');
    }

    public function render()
    {
        return view('livewire.slots-cashout-modal');
    }
}
