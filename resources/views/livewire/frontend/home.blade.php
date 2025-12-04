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
            <div class="w-auto! mx-auto flex justify-between mb-8 bg-bg-secondary rounded-full  px-4 py-3">
                <button @click="tab = 'buyers'; active = 0"
                    :class=" tab === 'buyers' ? 'bg-purple-700 px-7 py-3 rounded-full shadow-lg text-white w-auto!' :
                        'text-text-secondery px-7 w-auto!'"
                    class="transition-colors duration-300 font-medium">
                    {{ 'For Buyers' }}
                </button>
                <button @click="tab = 'sellers'; active = 0"
                    :class="tab === 'sellers' ? 'bg-purple-700 px-7 py-3 rounded-full shadow-lg text-white w-auto!' :
                        'text-text-secondery px-7 w-auto!'"
                    class="transition-colors duration-300 font-medium">
                    {{ __('For Sellers') }}
                </button>
            </div>

            <!-- FAQ Items for Buyers -->
            <template x-if="tab === 'buyers'">
                <div class="space-y-4">

                    <!-- Buyer FAQ Items -->
                    <div class="bg-bg-secondary rounded p-4 cursor-pointer"
                        @click="active === 0 ? active = null : active = 0">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">{{ __('How do I buy a product?') }}</h3>
                            <svg :class="active === 0 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 0" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('Browse or search for your desired digital product. Click on the product, review the details, click "Buy No select your preferred payment method.') }}
                        </p>
                    </div>

                    <div class="bg-bg-secondary rounded p-4 cursor-pointer"
                        @click="active === 1 ? active = null : active = 1">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">{{ __('What payment methods are accepted?') }}
                            </h3>
                            <svg :class="active === 1 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 1" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('We accept various payment methods including credit cards, PayPal, and more.') }}
                        </p>
                    </div>

                    <div class="bg-bg-secondary rounded p-4 cursor-pointer"
                        @click="active === 2 ? active = null : active = 2">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">{{ __('What is the buyer protection policy?') }}
                            </h3>
                            <svg :class="active === 2 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 2" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('Our buyer protection policy ensures secure transactions and support for any disputes.') }}
                        </p>
                    </div>

                    <div class="bg-bg-secondary rounded p-4 cursor-pointer"
                        @click="active === 3 ? active = null : active = 3">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">
                                {{ __('How do I receive my purchased digital product?') }}
                            </h3>
                            <svg :class="active === 3 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 3" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('After purchase, you will receive a download link or access instructions via email.') }}
                        </p>
                    </div>

                    <div class="bg-bg-secondary rounded p-4 cursor-pointer"
                        @click="active === 4 ? active = null : active = 4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">
                                {{ __("What if the seller doesn't deliver the product?") }}
                            </h3>
                            <svg :class="active === 4 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 4" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('Contact support immediately and we will assist you with dispute resolution.') }}
                        </p>
                    </div>
                </div>
            </template>

            <!-- FAQ Items for Sellers -->
            <template x-if="tab === 'sellers'">
                <div class="space-y-4">

                    <div class="bg-bg-secondary rounded p-4 cursor-pointer"
                        @click="active === 0 ? active = null : active = 0">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">{{ __('How do I become a seller?') }}</h3>
                            <svg :class="active === 0 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 0" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('Click "Start Selling" or register an account and navigate to the seller dashboard. You will need to complete our seller verification pr providing personal information and an ID document.') }}
                        </p>
                    </div>

                    <div class="bg-bg-secondary rounded p-4 cursor-pointer"
                        @click="active === 1 ? active = null : active = 1">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">
                                {{ __('Why do I need to be verified to sell?') }}</h3>
                            <svg :class="active === 1 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 1" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('Verification helps us ensure the authenticity and trustworthiness of sellers on our platform.') }}
                        </p>
                    </div>

                    <div class="bg-bg-secondary rounded p-4 cursor-pointer"
                        @click="active === 2 ? active = null : active = 2">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">
                                {{ __('What kind of digital products can I sell?') }}</h3>
                            <svg :class="active === 2 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 2" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('You can sell ebooks, music, software, design files, and other digital goods.') }}
                        </p>
                    </div>

                    <div class="bg-bg-secondary rounded p-4 cursor-pointer"
                        @click="active === 3 ? active = null : active = 3">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">{{ __('How do I list a product?') }}</h3>
                            <svg :class="active === 3 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 3" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('Register your product on the seller dashboard by providing the required details and uploading your files.') }}
                        </p>
                    </div>

                    <div class="bg-bg-secondary rounded p-4 cursor-pointer"
                        @click="active === 4 ? active = null : active = 4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">{{ __('How do I get paid?') }}</h3>
                            <svg :class="active === 4 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 4" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('Payments are processed securely via the platform, and funds are transferred according to your selected payout method.') }}
                        </p>
                    </div>

                </div>
            </template>
        </div>
    </section>
</main>
