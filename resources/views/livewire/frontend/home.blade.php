<main class="overflow-x-hidden-hidden">
    <!-- Hero Section -->

    <div class="swiper swiper-hero">
        <div class="swiper-wrapper">
            @forelse ($heros as $key => $hero)
                <div class="swiper-slide">
                    <x-home.hero :data="$hero" />
                </div>
            @empty
                <div class="swiper-slide">
                    <x-home.hero :data="null" />
                </div>
            @endforelse
        </div>
    </div>


    <!-- Popular Games Section -->
    <section class="py-20" id="popular-games">
        <div class="container">
            <div class="mb-10">
                <h2 class="text-40px font-bold mb-4 text-text-white">
                    {{ __('Newly Boosting') }}
                </h2>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($games as $key => $game)
                    @if ($key > 2)
                        @break
                    @endif

                    <div class="swiper-slide">
                        <x-game-card :data="$game" />
                    </div>
                @endforeach
            </div>

            <!-- Center indicator -->
            <div class="w-full flex justify-center mt-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-2 rounded-full bg-zinc-50"></div>
                    <div class="w-8 h-2 rounded-full bg-purple-600"></div>
                    <div class="w-8 h-2 rounded-full bg-zinc-50"></div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="mb-10 mt-20">
                <h2 class="text-40px font-bold mb-4 text-text-white">
                    {{ __('Popular Games') }}
                </h2>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($games as $key => $game)
                    @if ($key > 2)
                        @break
                    @endif

                    <div class="swiper-slide">
                        <x-game-card :data="$game" />
                    </div>
                @endforeach
            </div>

            <!-- Center indicator -->
            <div class="w-full flex justify-center mt-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-2 rounded-full bg-zinc-50"></div>
                    <div class="w-8 h-2 rounded-full bg-purple-600"></div>
                    <div class="w-8 h-2 rounded-full bg-zinc-50"></div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="mb-10 mt-20">
                <h2 class="text-40px font-bold mb-4 text-text-white">
                    {{ __('Top-Selling Offers') }}
                </h2>
            </div>

            <!-- Cards -->
            <div class="relative min-h-[40vh]">
                <!-- Skeleton Loading -->
                <x-loading-animation :target="'search, tagSelected, selectedDevice, selectedAccountType,  selectedPrice, selectedDeliveryTime , resetAllFilters'" />
                <!-- Actual Product Cards -->
                <div wire:loading.class="opacity-0"
                    wire:target="search, tagSelected, selectedDevice, selectedAccountType,  selectedPrice, selectedDeliveryTime , resetAllFilters"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4 w-full">

                    @foreach ($datas as $item)
                        <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" :data="$item" :game="$game" />
                    @endforeach

                </div>
            </div>
            {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($games as $key => $game)
                    @if ($key > 2)
                        @break
                    @endif

                    <div class="swiper-slide">
                        <x-game-card :data="$game" />
                    </div>
                @endforeach
            </div> --}}

            <!-- Center indicator -->
            <div class="w-full flex justify-center mt-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-2 rounded-full bg-zinc-50"></div>
                    <div class="w-8 h-2 rounded-full bg-purple-600"></div>
                    <div class="w-8 h-2 rounded-full bg-zinc-50"></div>
                </div>
            </div>
        </div>


    </section>

    <!-- How It Works Section -->
    <section class="py-20">
        <div class="container">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 text-text-white">{{ __('How It Works') }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-20 h-20 rounded-xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        <img src="{{ asset('assets/images/home_page/secure_transaction.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-text-white">{{ __('Secure Transactions') }}</h3>
                    <p class="text-text-secondary text-sm">
                        {{ __('Our platform uses industry-leading encryption to ensure your  transactions are safe and secure, guaranteeing asafeshopping experience.') }}
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center relative">
                    <div class="w-20 h-20 rounded-xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        <img src="{{ asset('assets/images/home_page/verified_sellers.png') }}" alt="">
                    </div>
                    <div class="absolute top-1/4 -left-1/4 z-20 hidden md:block">
                        <img src="{{ asset('assets/images/home_page/right-arrow.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-text-white">{{ __('Verified Sellers') }}</h3>
                    <p class="text-text-secondary text-sm">
                        {{ __('We meticulously verify each seller to ensure you receive genuine digital goods from trusted sources.') }}
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center relative">
                    <div class="w-20 h-20 rounded-xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        <img src="{{ asset('assets/images/home_page/effortless_buying.png') }}" alt="">
                    </div>
                    <div class="absolute top-1/4 -left-1/4 z-20 hidden md:block">
                        <img src="{{ asset('assets/images/home_page/right-arrow.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-text-white">
                        {{ __('Effortless Buying & Selling') }}
                    </h3>
                    <p class="text-text-secondary text-sm">
                        {{ __('Our intuitive platform streamlines the buying and selling process, set with quick delivery and software within reach.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="py-20 bg-gradient-to-r from-zinc-500  to-pink-900">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold mb-6 text-white ">{{ __('About us') }}</h2>
                    <p class="text-white/70 mb-4">
                        {{ __('Digital Commerce is your go-to destination for buying and selling high-quality digital products. We connect buyers and verified sellers, ensuring secure transactions, fast delivery, and dedicated support for a seamless experience.') }}
                    </p>
                    {{-- <button class="btn-primary">
                        <span><x-flux::icon name="user" class="w-6 h-6 inline-block" stroke="white" /></span>
                        Explore Products</button> --}}
                    <x-ui.button class=" py-2 w-auto!">
                        <flux:icon name="user"
                            class="w-5 h-5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                        {{ __('Explore Products') }}
                    </x-ui.button>
                </div>

                <div class="w-full h-full">
                    <img src="{{ asset('assets/images/home_page/about.png') }}" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <livewire:frontend.partials.faq :faqs_buyer="$faqs_buyer" :faqs_seller="$faqs_seller" />
    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.swiper-hero', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },

                    slidesPerView: 1, // Always 1 item
                    spaceBetween: 20,
                });
            });
        </script>
    @endpush
</main>
