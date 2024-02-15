<div
    class="max-w-screen-2xl w-full mx-auto flex flex-row gap-8 items-center justify-around p-24 slots__buttons select-none">

    @if ($this->canSpin)
        <button type="button" wire:click="$dispatch('openCashoutModal')"
            :disabled="{{ !$this->canCashOut ? 'true' : 'false' }}"
            class="transition-all bg-stone-500 hover:bg-stone-600 disabled:opacity-40 text-white px-16 py-4 rounded-md text-lg top-0 left-0 relative slots__buttons__cashout">Cash
            Out</button>
    @else
        <button type="button" wire:click="refreshSession"
            class="transition-all bg-stone-500 hover:bg-stone-600 disabled:opacity-40 text-white px-16 py-4 rounded-md text-lg">Insert
            Cash</button>
    @endif

    @if ($statusMessage !== '' && $statusMessage !== null)
        <div class="text-stone-800 text-lg flex-1 flex flex-col items-center justify-center slots__buttons__message">
            {{ $statusMessage }}</div>
    @else
        <div class="flex-1">&nbsp;</div>
    @endif

    <button type="button" wire:click="$dispatch('spin')" :disabled="{{ !$this->canSpin ? 'true' : 'false' }}"
        class="transition-all bg-stone-500 hover:bg-stone-600 disabled:opacity-40 text-white px-16 py-4 rounded-md text-lg">Spin</button>


    @script
        <script>
            const handleWackyCashOutButtonBehaviour = () => {

                const slotsButtonsMouseLeaveEventHandler = () => {
                    const slotsCashOutButton = document.querySelector('.slots__buttons__cashout');
                    if (slotsCashOutButton == null) return;

                    slotsCashOutButton.style.left = `0`;
                    slotsCashOutButton.style.top = `0`;

                    const originalDisabledState = slotsCashOutButton.getAttribute('data-original-disabled-state');
                    slotsCashOutButton.disabled = originalDisabledState === 'true';
                    slotsCashOutButton.removeAttribute('data-original-disabled-state');
                }

                const slotsCashOutButtonMouseEnterEventHandler = () => {
                    const slotsCashOutButton = document.querySelector('.slots__buttons__cashout');
                    if (slotsCashOutButton == null) return;

                    if (slotsCashOutButton.hasAttribute('data-original-disabled-state') !== true) {
                        const originalDisabledState = slotsCashOutButton.disabled;
                        slotsCashOutButton.setAttribute('data-original-disabled-state', originalDisabledState);
                    }


                    if (Math.random() <= 0.5) {
                        slotsCashOutButton.style.left = `${Math.floor(Math.random() * 600) - 300}px`;
                        slotsCashOutButton.style.top = `${Math.floor(Math.random() * 600) - 300}px`;
                    }

                    if (Math.random() <= 0.4) {
                        slotsCashOutButton.disabled = true;
                    }
                }

                const livewireInitializedEventHandler = () => {
                    const slotsButtons = document.querySelector('.slots__buttons')
                    if (slotsButtons == null) return;

                    slotsButtons.addEventListener('mouseleave', slotsButtonsMouseLeaveEventHandler)

                    const slotsCashOutButton = document.querySelector('.slots__buttons__cashout');
                    if (slotsCashOutButton == null) return;

                    slotsCashOutButton.addEventListener('mouseenter', slotsCashOutButtonMouseEnterEventHandler)
                }

                document.addEventListener('livewire:initialized', livewireInitializedEventHandler)

            };

            handleWackyCashOutButtonBehaviour();
        </script>
    @endscript
</div>
