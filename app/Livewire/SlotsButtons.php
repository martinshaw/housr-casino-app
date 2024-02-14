<?php

namespace App\Livewire;

use App\Repositories\SlotSymbolRepository;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class SlotsButtons extends Component
{
    #[Reactive]
    public string | null $statusMessage = null;
    
    public bool $hasSpun = false;

    public function mount()
    {
        $slotSymbolRepository = app(SlotSymbolRepository::class);
        $this->hasSpun = $slotSymbolRepository->getCurrentUsersLatestSpin() !== null;
    }

    public function render()
    {
        return view('livewire.slots-buttons');
    }
}
