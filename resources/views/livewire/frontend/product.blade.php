<main class="overflow-x-hidden bg-page ">
    {{-- filter section --}}

    <section class="container mx-auto relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 md:gap-6 mb-13 mt-15">
            <div>
                <h2 class="font-semibold text-4xl pb-3">{{ $category->name }}</h2>
                @if ($category->icon)
                    <p class="text-base lg:text-xl text-text-white font-light pb-3 ">
                        {!! $category->meta_description !!}
                    </p>
                @endif
            </div>
            @if ($category->icon)
                <div class="h-40 md:h-80 w-full rounded-2xl overflow-hidden bg-bg-secondary col-span-2">
                    <img src="{{ storage_url($category->icon) }}" alt="category banner"
                        class="w-full h-full object-cover rounded-lg">
                </div>
            @endif
        </div>

        <div class="flex items-center justify-between gap-4 mt-3.5 relative">
            <div class="flex-1 w-auto md:min-w-64">
                <div class="relative">
                    <input type="text" placeholder="Search" wire:model.live.debounce.300ms="search"
                        class="w-full bg-bg-transparent rounded-full border border-zinc-700 px-4 py-2 pl-10 focus:outline-none focus:border-zinc-500">
                    <span class="absolute left-3 top-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </span>
                </div>
            </div>

            <div class="min-w-30 flex items-center justify-center gap-2 relative" x-data="{ filter: false }">
                {{-- Filter Button --}}
                <button @click="filter = !filter"
                    class="flex items-center gap-2 px-4 py-2.5 bg-bg-transparent rounded-full border border-zinc-700">

                    <span class="text-text-white text-sm">
                        @if ($sortOrder === 'asc')
                            {{ __('a-z') }}
                        @elseif($sortOrder === 'desc')
                            {{ __('z-a') }}
                        @endif
                    </span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>

                {{-- Dropdown --}}
                <div class="absolute top-full mt-2 right-0 shadow-glass-card min-w-31" x-show="filter" x-transition
                    x-cloak @click.outside="filter = false" style="z-index: 9999;">
                    <div class="bg-bg-primary rounded-md p-4 border border-zinc-700">
                        <div class="flex flex-col gap-2">
                            <button wire:click="sortBy('asc')" @click="filter = false"
                                class="text-left px-3 py-2 rounded transition {{ $sortOrder === 'asc' ? 'bg-bg-hover' : 'hover:bg-bg-hover' }}">
                                {{ __('A-Z') }}
                            </button>
                            <button wire:click="sortBy('desc')" @click="filter = false"
                                class="text-left px-3 py-2 rounded transition {{ $sortOrder === 'desc' ? 'bg-bg-hover' : 'hover:bg-bg-hover' }}">
                                {{ __('Z-A') }}
                            </button>
                            <button wire:click="sortBy('default')" @click="filter = false"
                                class="text-left px-3 py-2 rounded transition {{ $sortOrder === 'default' ? 'bg-bg-hover' : 'hover:bg-bg-hover' }}">
                                {{ __('Default') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="relative z-5">

        {{-- To Ensure that if it is not a gift card category then title will visible --}}
        @if ($categorySlug != 'gift-card')
            <section class="container mx-auto mt-10">
                <div class="title mt-10">
                    <h2 class="font-semibold text-40px">{{ __('Popular') }}
                        {{ $categorySlug == 'top-up' || $categorySlug == 'coaching' ? 'Now' : ucfirst(str_replace('-', ' ', $categorySlug)) }}
                    </h2>
                </div>
                <div wire:ignore class="swiper popular-currency">
                    <div class="swiper-wrapper pt-10">
                        @foreach ($popular_games as $popular_game)
                            <div class="swiper-slide">
                                <x-product-card :data="$popular_game" :categorySlug="$categorySlug" />
                            </div>
                        @endforeach
                    </div>

                    <!-- Add Pagination and Navigation -->
                    <div class="mt-12">
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </section>
        @endif

        {{-- To Ensure that if it is not a gift card category then title will visible --}}
        @if ($categorySlug == 'boosting' || $categorySlug == 'coaching' || $categorySlug == 'top-up')
            <section class="container mx-auto mt-10">
                <div class="title mt-10">
                    <h2 class="font-semibold text-40px">{{ __('New') }}
                        {{ $categorySlug == 'top-up' || $categorySlug == 'coaching' ? 'Launched' : ucfirst(str_replace('-', ' ', $categorySlug)) }}
                    </h2>
                </div>
                <div wire:ignore class="swiper new-boosting">
                    <div class="swiper-wrapper pt-10">
                        @foreach ($new_boosting as $index => $boosting_game)
                            <div class="swiper-slide">
                                <x-product-card :data="$boosting_game" :categorySlug="$categorySlug" />
                            </div>
                        @endforeach
                    </div>

                    <!-- Add Pagination and Navigation -->
                    <div class="mt-12">
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </section>
        @endif

        {{-- All Currency --}}
        <section class="container mx-auto mt-10">
            {{-- To Ensure that if it is not a gift card category then title will visible --}}
            @if ($categorySlug != 'gift-card')
                <div class="title mb-10">
                    <h2 class="font-semibold text-40px">{{ __('All') }}
                        {{ $categorySlug == 'top-up' || $categorySlug == 'coaching' ? ($categorySlug == 'top-up' ? 'Top Up' : 'All brands for Coaching') : Str::ucfirst($categorySlug) }}
                    </h2>
                </div>
            @endif

            <div
                class="grid grid-cols-1 sm:grid-cols-2 {{ $categorySlug == 'gift-card' ? 'lg:grid-cols-4' : 'lg:grid-cols-3' }} gap-6 md:gap-8 lg:gap-6">

                @foreach ($games as $game)
                    <x-product-card :data="$game" :categorySlug="$categorySlug" />
                @endforeach
            </div>
            <div class="pagination mb-24 mt-10">
                <x-frontend.pagination-ui :pagination="$pagination" />
            </div>
        </section>
    </section>


    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {

                const swiper = new Swiper('.popular-currency', {
                    loop: false, // IMPORTANT for correct bullets
                    slidesPerView: 1,
                    slidesPerGroup: 1,
                    spaceBetween: 20,

                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },

                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            slidesPerGroup: 2,
                        },
                        1024: {
                            slidesPerView: 3,
                            slidesPerGroup: 3,
                        },
                    },
                });

            });




            document.addEventListener('livewire:navigated', function() {

                const swiper = new Swiper('.new-boosting', {
                    loop: false, // IMPORTANT for correct bullets
                    slidesPerView: 1,
                    slidesPerGroup: 1,
                    spaceBetween: 20,

                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },

                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },

                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            slidesPerGroup: 2,
                        },
                        1024: {
                            slidesPerView: 3,
                            slidesPerGroup: 3,
                        },
                    },
                });

            });
        </script>
    @endpush
</main>
