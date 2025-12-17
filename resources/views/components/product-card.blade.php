@props([
    'data' => null,
    'categorySlug' => null
])


<div class="bg-bg-secondary p-6 rounded-2xl w-full max-w-sm mx-auto sm:mx-0">
    <div class="images w-full h-60 sm:h-48 md:h-68">
        <img src="{{ storage_url($data->logo) }}" alt="{{ $data->name }}"
            class="w-full h-full object-cover rounded-lg">
    </div>
    <div class="">
        <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5 text-text-white line-clamp-1">
            {{ $data->name }}
        </h3>
        <p class="text-pink-500 mb-0">{{ __('50 offer') }}</p>
        <a href="{{ route('game.index', ['categorySlug' => $categorySlug, 'gameSlug' => $data->slug]) }}"
        wire:navigate>
        
        </a>

    </div>
</div>