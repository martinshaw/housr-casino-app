<div class="aspect-square border border-stone-700 w-full flex flex-col items-center justify-center gap-8 p-8">

    @php
        use App\Repositories\SlotSymbol;
    @endphp

    @switch($slotSymbol)
        @case(SlotSymbol::Cherry)
            <div class="flex-1 flex flex-col items-center justify-center font-mono text-4xl text-stone-400">C</div> 
            <div class="flex flex-col items-center justify-center">Cherry</div>
        @break

        @case(SlotSymbol::Lemon)
            <div class="flex-1 flex flex-col items-center justify-center font-mono text-4xl text-stone-400">L</div> 
            <div class="flex flex-col items-center justify-center">Lemon</div>
        @break

        @case(SlotSymbol::Orange)
            <div class="flex-1 flex flex-col items-center justify-center font-mono text-4xl text-stone-400">O</div> 
            <div class="flex flex-col items-center justify-center">Orange</div>
        @break

        @case(SlotSymbol::Watermelon)
            <div class="flex-1 flex flex-col items-center justify-center font-mono text-4xl text-stone-400">W</div> 
            <div class="flex flex-col items-center justify-center">Watermelon</div>
        @break

        @default
            IDK?
    @endswitch

</div>
