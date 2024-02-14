<?php

namespace App\Livewire;

use App\Enums\SlotSymbol;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class SlotsGridBox extends Component
{
    #[Modelable]
    public SlotSymbol | null $slotSymbol;

    public function render(): View
    {
        return view('livewire.slots-grid-box');
    }
}
