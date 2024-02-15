<div class="absolute top-0 left-0 z-50 w-screen h-screen slots__cashout-modal">
    <form class="flex flex-col items-center justify-center w-full h-full">
        <div class="text-stone-600 text-3xl font-bold mb-8">Really?</div>
        <div class="text-stone-800 text-lg mb-8">You have {{ $this->userCreditsCount }} credit{{ $this->userCreditsCount === 1 ? '' : 's' }}. Are you sure you don't want to keep playing?</div>
        
        <div class="flex flex-row gap-8 items-center justify-around select-none">
            <button type="button" wire:click="navigateToCashout" class="transition-all bg-stone-200 text-stone-600 hover:bg-stone-300 hover:text-stone-700 px-16 py-4 rounded-md text-lg">Yes, I'm a loser, cash me out.</button>
            <button type="button" wire:click="$dispatch('closeCashoutModal')" class="transition-all bg-stone-500 text-white hover:bg-stone-600 px-16 py-4 rounded-md text-lg">No, I want to win!</button>
        </div>
    </form>
</div>
