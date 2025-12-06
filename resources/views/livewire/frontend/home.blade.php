<main class="overflow-x-hidden-hidden">
    <!-- Hero Section -->

    <x-home.hero :hero="$hero"/>

    <!-- Popular Games Section -->
    <section class="py-20" id="popular-games">
      
        <div class="container">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 text-text-white">{{ __('Popular Games') }}</h2>
                <p class="text-text-secondary">{{ __('Find coins, items, and services for your favorite games.') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Game Card 1 -->
                @foreach ($games as $game)
                    <div class="swiper-slide">
                        <x-game-card :data="$game" />
                    </div>
                @endforeach
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
    <section class="py-20 bg-bg-primary">
        <div class="container py-8 flex justify-center wrap flex-col" x-data="{ active: 0, tab: 'buyers' }">

            <h2 class="text-text-white text-center  mb-6 font-semibold">{{ 'Frequently Asked Questions' }}
            </h2>

            <!-- Tabs -->
            <div class="max-w-xs mx-auto flex justify-between mb-8 bg-bg-primary rounded-full px-4 py-3">
                <button @click="tab = 'buyers'; active = 0" 
                    :class="tab === 'buyers' ? 'bg-purple-700 px-5 py-3 rounded-full shadow-lg text-white' :
                        'text-text-secondery px-7'"
                    class="transition-colors duration-300 font-medium">
                    {{ 'For Buyers' }}
                </button>
                <button @click="tab = 'sellers'; active = 0" 
                    :class="tab === 'sellers' ? 'bg-purple-700 px-5 py-3 rounded-full shadow-lg text-white' :
                        'text-text-secondery px-7'"
                    class="transition-colors duration-300 font-medium">
                    {{ __('For Sellers') }}
                </button>
            </div>

            <!-- FAQ Items for Buyers -->
            <template x-if="tab === 'buyers'">
                <div class="space-y-4">

                    @foreach ($faqs_buyer as $index => $faq )

                  

                        <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === {{ $index }} ? active = null : active = {{$index}}">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">{{ $faq->question }}</h3>
                            <svg :class="active === 0 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === {{ $index }}" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ $faq->answer }}
                        </p>
                    </div>
                    @endforeach
                    <!-- Buyer FAQ Items -->
                    

                </div>
            </template>

            <!-- FAQ Items for Sellers -->
            <template x-if="tab === 'sellers'">
                <div class="space-y-4">

                 @foreach ($faqs_seller as $index => $faq )
                        <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === {{ $index }} ? active = null : active = {{$index}}">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">{{ $faq->question }}</h3>
                            <svg :class="active === 0 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === {{ $index }}" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ $faq->answer }}
                        </p>
                    </div>
                    @endforeach


                </div>
            </template>
        </div>
    </section>
</main>
