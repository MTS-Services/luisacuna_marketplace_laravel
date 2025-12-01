<main class="mx-auto">
    <section class="container mx-auto">
        {{-- paginate --}}
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
                {{ __('Items') }}
            </h1>
        </div>
        <div class="title mb-5">
            <h2 class="font-semibold text-4xl">{{ __('Items') }}</h2>
        </div>
        {{-- filter section --}}
        <x-filter :sortOrder="$sortOrder"/>
    </section>

    {{-- popular items --}}
    <section class="container mx-auto">
        <div class="mt-10">
            <div class="">
                <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{ __('Popular Items') }}
                </h2>
            </div>
            <div wire:ignore class="swiper popular-items">
                <div class="swiper-wrapper py-10">
                    @foreach ($popular_items as $popular_item)
                        <div class="swiper-slide">
                            <x-currency-card :data="$popular_item" />
                        </div>
                    @endforeach
                    {{-- <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68">
                                    <img src="{{ asset('assets/images/items/Grand-Thef- Auto5.jpg') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">
                                        {{ __('Grand Theft Auto 5') }}
                                    </h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'items', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Valorant.jpg') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">
                                        {{ __('Valorant') }}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'items', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">
                                        {{ __('Call of Duty') }}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'items', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">
                                        {{ __('Call of Duty') }}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'items', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">
                                        {{ __('Call of Duty') }}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'items', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div> --}}
                </div>

                <!-- Add Pagination and Navigation -->
                <div class="mt-10">
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- all items --}}
    <section class="container mx-auto mt-10">
        <div class="mb-10">
            <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{ __('All Item') }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-center gap-6">
            @foreach ($items as $item)
                <x-currency-card :data="$item" />
            @endforeach
        </div>

        <div class="pagination mb-24">
            <x-frontend.pagination-ui :pagination="$pagination" />
        </div>
    </section>
    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.popular-items', {
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
