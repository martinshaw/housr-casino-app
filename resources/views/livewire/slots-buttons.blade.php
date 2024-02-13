<div class="flex flex-row gap-8 items-center justify-around p-24">

    @if ($errorMessage !== null)
        <div class="text-stone-500 text-lg">{{ $errorMessage }}</div>
    @endif

    <button type="button" wire:click="cashOut" :disabled="{{$errorMessage !== null}}" class="bg-stone-500 disabled:opacity-40 text-white px-16 py-4 rounded-md text-lg">Cash Out</button>

    <button type="button" wire:click="spin" :disabled="{{$errorMessage !== null}}" class="bg-stone-500 disabled:opacity-40 text-white px-16 py-4 rounded-md text-lg">Spin</button>

</div>
