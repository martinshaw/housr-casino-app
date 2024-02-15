<div class="flex-1 w-full flex flex-row justify-center gap-8 py-8 px-10 select-none slots__grid">
    <form wire:submit.prevent="submit" class="max-w-screen-md w-full h-full flex flex-col items-center justify-center gap-8">
        <div class="text-stone-600 text-3xl font-bold mb-8 text-center">Cashing Out...</div>
        <div class="text-stone-800 text-lg text-center">You have {{ $this->userCreditsCount }} credit{{ $this->userCreditsCount === 1 ? '' : 's' }}. To cash them out, please enter your name and e-mail address</div>
        
        <div class="my-8 w-full flex flex-col gap-8">
            <div class="flex flex-col gap-4 w-full">
                <input type="text" wire:model.live="name" class="px-4 py-3 w-full border rounded" placeholder="Your Name" />
                @error('name') 
                    <div class="text-red-800 text-sm mb-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex flex-col gap-4 w-full">
                <input type="email" wire:model.live="email" class="px-4 py-3 w-full border rounded" placeholder="E-mail Address" />
                @error('email') 
                    <div class="text-red-800 text-sm mb-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex flex-row gap-8 items-center justify-around select-none">
            <button type="button" wire:click="navigateToSlots" class="transition-all bg-stone-200 text-stone-600 hover:bg-stone-300 hover:text-stone-700 px-16 py-4 rounded-md text-lg">No, I want to keep playing!</button>
            <button type="submit" :disabled="{{ !$this->canSubmit }}" class="transition-all bg-stone-500 text-white hover:bg-stone-600 disabled:opacity-40 px-16 py-4 rounded-md text-lg">I'm Done.</button>
        </div>
    </form>

    @if ($isSuccess)
        <div class="absolute top-0 left-0 z-50 w-screen h-screen slots__cashout-modal">
            <form class="flex flex-col items-center justify-center w-full h-full">
                <div class="text-stone-600 text-3xl font-bold mb-8">Congratulations {{ $name }}!</div>
                <div class="text-stone-800 text-lg mb-8">You have cashed out {{ $originalUserCreditsCount }} credit{{ $originalUserCreditsCount === 1 ? '' : 's' }}. </div>
                
                <div class="flex flex-row gap-8 items-center justify-around select-none">
                    <button type="button" wire:click="navigateToSlots" class="transition-all bg-stone-500 text-white hover:bg-stone-600 px-16 py-4 rounded-md text-lg">Get back to winning!</button>
                </div>
            </form>
        </div>
    
    @endif
</div>
