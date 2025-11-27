@props([
    'data' => null,
])


<div class="bg-bg-primary p-6 rounded-2xl">
    <div class="images w-full h-60 sm:h-48 md:h-68">
        <img src="{{ storage_url($data->logo) }}" alt="{{ $data->name }}"
            class="w-full h-full object-cover rounded-lg">
    </div>
    <div class="">
        <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white line-clamp-1">
            {{ $data->name }}</h3>
        <p class="text-pink-500 mb-8">{{ __('50 offer') }}</p>
        <a href="{{ route('game.index', ['categorySlug' => 'currency', 'gameSlug' => 'exilecon-official-trailer']) }}"
            wire:navigate>
            <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{ __('See Seller List') }}</x-ui.button>
        </a>
    </div>
</div>