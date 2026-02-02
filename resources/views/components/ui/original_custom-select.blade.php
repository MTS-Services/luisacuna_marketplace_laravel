@props([
    'label' => 'Select Option',
    'onChange' => null,
    'options' => [],
    'wireModel' => null,
    'dropDownClasses' => '',
])

<div class="relative w-full" x-data="{
    open: false,
    selectedOption: @js($label),
    wireModel: @js($wireModel),
    onChange: @js($onChange)
}"
    @click.away="open = false">

    {{-- Hidden input for wire:model --}}
    <input type="hidden" wire:model="{{ $wireModel }}">

    {{-- Dropdown Trigger --}}
    <div @click="open = !open" {!! $attributes->merge([
        'class' =>
            'flex justify-between bg-bg-primary items-center px-3 py-2 cursor-pointer border border-zinc-700 rounded-full w-full',
    ]) !!}>
        <span x-text="selectedOption"></span>
        <svg class="w-5 h-5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    {{-- Dropdown Menu --}}
    <div @click.stop 
        x-show="open" 
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-y-0" 
        x-transition:enter-end="opacity-100 scale-y-100"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 scale-y-100" 
        x-transition:leave-end="opacity-0 scale-y-0"
        class="absolute top-[110%] left-0 w-full rounded bg-bg-primary z-20 overflow-hidden origin-top overflow-y-auto max-h-[50vh] border border-zinc-700 {{ $dropDownClasses }}">
        <ul class="list-none space-y-2 px-2 py-2">
            {{ $slot }}
        </ul>
    </div>
</div>