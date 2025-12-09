<main class="overflow-x-hidden">
    {{-- filter section --}}
    <section class="container mx-auto">
        <div class="flex items-center gap-1 my-10 font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <div class="text-muted text-base">
                <a href="{{ route('home') }}" class="text-base text-text-white">{{ __('Home') }}</a>
            </div>
            <div class="px-2 text-text-white text-base">
                >
            </div>
            <h1 class="text-text-white text-base">
               {{ Str::ucfirst($categorySlug) }}
            </h1>
        </div>


        <div class="title mb-5">
            <h2 class="font-semibold text-4xl">{{ Str::ucfirst($categorySlug) }}</h2>
        </div>

        {{-- Filter --}}
        {{-- <x-filter :sortOrder="$sortOrder" /> --}}
        {{-- Filter --}}

        <div class="flex items-center justify-between gap-4 mt-3.5">
            <div class="search w-full">
                <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..."
                    class="form-input w-full  border border-zinc-700"  />
            </div>
            <div class="min-w-30 flex items-center justify-between gap-2 relative" x-data={filter:false}>

                {{-- Filter Button --}}
                <button @click="filter = !filter"
                    class="flex items-center gap-2 px-4 py-2.5 bg-bg-primary rounded-md border! border-zinc-700!">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4 4v-9L3 6V4z" />
                    </svg>
                    <span class="text-text-white text-sm">
                        @if ($sortOrder === 'asc')
                            {{ __('a-z') }}
                        @elseif($sortOrder === 'desc')
                            {{ __('z-a') }}
                        @else
                            {{ __('Default') }}
                        @endif
                    </span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>

                {{-- Dropdown --}}
                <div class="absolute top-12 right-[-7%] z-10 shadow-glass-card min-w-31" x-show="filter" x-transition
                    x-cloak @click.outside="filter = false">
                    <div class="bg-bg-primary rounded-md p-4">
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
    {{-- popular currency --}}
    <section class="container mx-auto mt-10">
        <div class="title mt-10">
            <h2 class="font-semibold text-40px">{{ __('Popular') }} {{ Str::ucfirst($categorySlug) }}</h2>
        </div>
        <div wire:ignore class="swiper popular-currency">
            <div class="swiper-wrapper py-10">
                @foreach ($popular_games as $popular_game)
                    <div class="swiper-slide">
                        <x-currency-card :data="$popular_game" :categorySlug="$categorySlug" />
                    </div>
                @endforeach
            </div>

            <!-- Add Pagination and Navigation -->
            <div class="mt-10">
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
    {{-- All Currency --}}
    <section class="container mx-auto mt-10">
        <div class="title mb-10">
            <h2 class="font-semibold text-40px">{{ __('All') }} {{ Str::ucfirst($categorySlug) }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 lg:gap-6">

            @foreach ($games as $game)
                <x-currency-card :data="$game" :categorySlug="$categorySlug" />
            @endforeach
        </div>
        <div class="pagination mb-24">
            {{-- <x-frontend.pagination-ui :pagination="$pagination" /> --}}
            {{ $games->links() }}
        </div>
    </section>
    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.popular-currency', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    // navigation: {
                    //     nextEl: '.swiper-button-next',
                    //     prevEl: '.swiper-button-prev',
                    // },
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    slidesPerView: 1,
                    spaceBetween: 20,
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                        },

                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });

            });
        </script>
    @endpush
</main>
