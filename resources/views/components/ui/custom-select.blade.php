@props([
    'options' => [],  
    'model' => '',
])

<div class="flex-nowrap gap-5 relative hidden md:flex"
     x-data="{ open: false, selectedOption: '' }"
     @click.away="open = false">

    <div class="flex justify-between border border-zinc-700 bg-bg-primary items-center w-50 px-2 py-2 rounded cursor-pointer"
         @click="open = !open">
        <span x-text="selectedOption || '{{ __('Platform') }}'"></span>
        <flux:icon name="chevron-down" class="w-5 h-5" />

        <!-- FIXED INPUT -->
        <input type="hidden"
               x-model="selectedOption"
               wire:model="{{ $model }}">
    </div>

    <div class="absolute top-[110%] left-0 w-50! rounded bg-bg-primary border border-zinc-700 z-20"
         x-show="open"
         x-transition
         @click.stop>

        <ol class="list">

            <li class="py-3 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-zinc-700"
                @click="selectedOption = '{{ __('Platform') }}'; open = false; $wire.set('{{ $model }}', ''); $wire.call('serachFilter')">
                {{ __('Platform') }}
            </li>

            @foreach ($options as $option)
                <li class="py-3 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-zinc-700"
                    @click="selectedOption = '{{ $option }}'; open = false; $wire.set('{{ $model }}', '{{ $option }}'); $wire.call('serachFilter')">
                    {{ $option }}
                </li>
            @endforeach

        </ol>
    </div>
</div>
