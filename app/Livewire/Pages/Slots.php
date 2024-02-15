<?php

namespace App\Livewire\Pages;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Slots extends Component
{
    public bool $showCashoutModal = false;

    #[On('openCashoutModal')]
    public function openCashoutModal(): void
    {
        $this->showCashoutModal = true;
    }

    #[On('closeCashoutModal')]
    public function closeCashoutModal(): void
    {
        $this->showCashoutModal = false;
    }

    public function render(): View
    {
        return view('livewire.pages.slots');
    }
}
