<?php

namespace App\Livewire;

use App\Repositories\PersistentUserMigrationRepository;
use App\Repositories\UserCreditAllocationRepository;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SlotsCashoutForm extends Component
{
    private UserCreditAllocationRepository $userCreditAllocationRepository;
    private PersistentUserMigrationRepository $persistentUserMigrationRepository;

    #[Validate("required|min:3")]
    public string $name = '';

    #[Validate("required|email")]
    public string $email = '';

    public bool $isSuccess = false;

    #[Computed]
    public function userCreditsCount(): int
    {
        return $this->userCreditAllocationRepository->getCurrentUserCreditsCount();
    }

    public int $originalUserCreditsCount = 0;

    #[Computed]
    public function canSubmit(): bool
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return false;
        }

        return true;
    }

    public function __construct()
    {
        $this->userCreditAllocationRepository = app(UserCreditAllocationRepository::class);
        $this->persistentUserMigrationRepository = app(PersistentUserMigrationRepository::class);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function submit()
    {
        $this->validate();

        $this->originalUserCreditsCount = $this->userCreditsCount;

        $this->persistentUserMigrationRepository->migrateCurrentAnonymousUserToPersistentUser(
            $this->name,
            $this->email
        );

        $this->isSuccess = true;
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
