<?php

namespace App\Livewire;

use App\Repositories\UserCreditAllocationRepository;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class SlotsHeader extends Component
{
    public int $userCreditsCount = 0;

    #[On('spin')]
    public function onSpin(): void
    {
        $this->refreshUserCreditsCount();
    }

    public function mount(): void
    {
        $this->refreshUserCreditsCount();
    }

    private function refreshUserCreditsCount(): void
    {
        $this->userCreditsCount = app(UserCreditAllocationRepository::class)->getCurrentUserCreditsCount();
    }

    public function render(): View
    {
        return view('livewire.slots-header');
    }
}
