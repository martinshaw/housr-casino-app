<?php

namespace App\Livewire;

use App\Repositories\UserCreditAllocationRepository;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SlotsCashoutForm extends Component
{
    private UserCreditAllocationRepository $userCreditAllocationRepository;

    #[Validate("required|min:3")]
    public string $name = '';

    #[Validate("required|email")]
    public string $email = '';

    #[Computed]
    public function userCreditsCount(): int
    {
        return $this->userCreditAllocationRepository->getCurrentUserCreditsCount();
    }

    public function __construct()
    {
        $this->userCreditAllocationRepository = app(UserCreditAllocationRepository::class);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function submit()
    {
        $this->validate();

        // Do user migration
    }

    public function navigateToSlots()
    {
        return redirect()->route('slots');
    }

    public function render()
    {
        return view('livewire.slots-cashout-form');
    }
}
