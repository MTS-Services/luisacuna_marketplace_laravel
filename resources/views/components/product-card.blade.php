@props([
    'data' => null,
    'categorySlug' => null,
])

@if ($categorySlug == 'gift-card')
    <a href="{{ route('game.index', ['categorySlug' => $categorySlug, 'gameSlug' => $data->slug]) }}">
        <div class="relative bg-bg-primary dark:bg-bg-secondary p-0 rounded-2xl w-full max-w-sm mx-auto sm:mx-0">
            <div class="images w-full h-60 sm:h-48 md:h-68">
                <img src="{{ storage_url($data->logo) }}" alt="{{ $data->name }}"
                    class="w-full h-full object-cover rounded-lg">
            </div>
            <div class="absolute top-2 right-1.5 bg-bg-hover font-normal text-white px-4 py-1 rounded-full text-sm ">
                <p class="text-text-primary mb-0">{{ $data->products_count }} {{ __('offers') }}</p>
            </div>
        </div>
    </a>
@else
    <a href="{{ route('game.index', ['categorySlug' => $categorySlug, 'gameSlug' => $data->slug]) }}">
        <div class="bg-bg-primary dark:bg-bg-secondary p-6 rounded-2xl w-full max-w-sm mx-auto sm:mx-0">
            <div class="images w-full h-60 sm:h-48 md:h-68">
                <img src="{{ storage_url($data->logo) }}" alt="{{ $data->name }}"
                    class="w-full h-full object-cover rounded-lg">
                
            </div>
            <div class="">
                <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5 text-text-white line-clamp-1">
                    {{ $data->gameTranslations->first()?->name ?? $data->name }}

                    {{-- {{ $item->gameTranslations->first()?->name ?? $item->name }} --}}
                </h3>
                @if ($categorySlug == 'currency' || $categorySlug == 'gift-card')
                    <p class="text-pink-500 mb-0">{{ $data->products_count }} {{ __('offers') }}</p>
                @endif
            </div>
        </div>
    </a>
@endif
