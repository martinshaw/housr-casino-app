<div class="flex flex-row justify-between gap-8 py-8 px-10 select-none slots__header">
    <div>Welcome to <span class="text-emerald-700 font-bold">Housr</span> Casino</div>
    <div>You have {{ $this->userCreditsCount === 0 ? "no" : $this->userCreditsCount }} credit{{ $this->userCreditsCount === 1 ? '' : 's' }}</div>
</div>
