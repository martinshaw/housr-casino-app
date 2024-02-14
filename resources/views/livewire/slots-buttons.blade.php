<div class="flex flex-row gap-8 items-center justify-around p-24">

    @if ($statusMessage !== null)
        <div class="text-stone-500 text-lg">{{ $statusMessage }}</div>
    @endif

    <button type="button" wire:click="$dispatch('cashOut')" :disabled="{{$statusMessage !== null || $hasSpun !== true}}" class="bg-stone-500 disabled:opacity-40 text-white px-16 py-4 rounded-md text-lg">Cash Out</button>

    <button type="button" wire:click="$dispatch('spin')" :disabled="{{$statusMessage !== null}}" class="bg-stone-500 disabled:opacity-40 text-white px-16 py-4 rounded-md text-lg">Spin</button>

</div>
