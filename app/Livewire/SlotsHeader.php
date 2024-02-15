<?php

namespace App\Livewire;

use App\Repositories\UserCreditAllocationRepository;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class SlotsHeader extends Component
{
    private UserCreditAllocationRepository $userCreditAllocationRepository;

    public int $userCreditsCount = 0;

    public function __construct()
    {
        $this->userCreditAllocationRepository = app(UserCreditAllocationRepository::class);
    }

    #[On('afterSpin')]
    public function onAfterSpin(): void
    {
        $this->refreshUserCreditsCount();
    }

    public function mount(): void
    {
        $this->refreshUserCreditsCount();
    }

    private function refreshUserCreditsCount(): void
    {
        $this->userCreditsCount = $this->userCreditAllocationRepository->getCurrentUserCreditsCount();
    }

    public function render(): View
    {
        return view('livewire.slots-header');
    }
}
