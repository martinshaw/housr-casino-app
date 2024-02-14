<div class="w-full flex flex-col items-center justify-center gap-8 ">
    <div
        class="aspect-square w-full border border-stone-700 bg-white flex flex-col items-center justify-center gap-8 p-16">

        <div class="flex-1 flex flex-col items-center justify-center font-mono text-7xl text-stone-400">
            {{ $slotSymbol->value }}</div>
        <div class="flex flex-col items-center justify-center">{{ implode(' ', Str::ucsplit($slotSymbol->name)) }}</div>

    </div>
</div>
