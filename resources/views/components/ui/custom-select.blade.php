@props([
    'label' => 'Select', 
    'options' => [], 
    'wireModel' => null, 
    'width' => 'w-full',
    'mdWidth' => 'md:w-[60%]',
    'border' => 'border-zinc-700',
    'rounded' => 'rounded-full',
    'mdLeft' => 'md:left-[20%]',
    'onChange' => null
])

<div class="flex flex-nowrap gap-5 relative justify-center items-center"
     x-data="{ 
        open: false, 
        selectedOption: @js($label)
     }"
     @click.away="open = false">

    {{-- Hidden input for Livewire binding --}}
    <input type="hidden" wire:model="{{ $wireModel }}">

    {{-- Dropdown Trigger --}}
    <div @click="open = !open"
         class="flex justify-between bg-bg-primary items-center px-3 py-2 cursor-pointer border {{ $border }} {{ $rounded }} {{ $width }} {{ $mdWidth }}">
        <span x-text="selectedOption"></span>
        <svg class="w-5 h-5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
         class="absolute top-[110%] left-0 rounded bg-bg-primary z-20 overflow-hidden origin-top overflow-y-auto max-h-[50vh] {{ $border }} {{ $rounded }} {{ $width }} {{ $mdWidth }} {{ $mdLeft }}">
        <ul class="list-none space-y-2 px-2 py-2">
            <li class="py-2 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                @click="selectedOption = @js($label); $wire.set('{{ $wireModel }}', ''); open = false; @if($onChange) $wire.call('{{ $onChange }}') @endif">
                {{ $label }}
            </li>
            @foreach($options as $item)
                <li class="py-2 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                    @click="selectedOption = @js($item->name ?? $item); $wire.set('{{ $wireModel }}', @js($item->id ?? $item)); open = false; @if($onChange) $wire.call('{{ $onChange }}') @endif">
                    {{ $item->name ?? $item }}
                </li>
            @endforeach
        </ul>
    </div>
</div>