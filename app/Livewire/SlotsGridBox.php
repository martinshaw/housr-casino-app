<?php

namespace App\Livewire;

use App\Repositories\SlotSymbol;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class SlotsGridBox extends Component
{
    #[Modelable]
    public SlotSymbol | null $slotSymbol;

    public function render()
    {
        return view('livewire.slots-grid-box');
    }
}
