<div class="max-w-screen-2xl w-full mx-auto flex flex-row gap-8 items-center justify-around p-24 slots__buttons select-none">

    <button type="button" wire:click="$dispatch('openCashoutModal')" :disabled="{{!$this->canCashOut}}" class="transition-all bg-stone-500 hover:bg-stone-600 disabled:opacity-40 text-white px-16 py-4 rounded-md text-lg">Cash Out</button>
    
    @if ($statusMessage !== '' && $statusMessage !== null)
        <div class="text-stone-800 text-lg flex-1 flex flex-col items-center justify-center slots__buttons__message">{{ $statusMessage }}</div>
    @else
        <div class="flex-1">&nbsp;</div>
    @endif

    <button type="button" wire:click="$dispatch('spin')" :disabled="{{!$this->canSpin}}" class="transition-all bg-stone-500 hover:bg-stone-600 disabled:opacity-40 text-white px-16 py-4 rounded-md text-lg">Spin</button>

</div>
