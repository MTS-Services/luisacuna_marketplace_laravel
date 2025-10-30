<main class="overflow-x-hidden">
    <!-- Hero Section -->
    <section class=" relative py-20 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-gradient-to-r from-purple-950/50 via-text-white to-purple-950/50">
            <div class="absolute top-50 -translate-y-1/2 left-0 w-32 h-32 md:w-auto md:h-auto">
                <img src="{{ asset('assets/images/home_page/Frame 62.png') }}" alt=""
                    class="w-full h-full object-fit">
            </div>

            <div class="absolute top-50 translate-y-[-50%] right-0 z-10 w-32 h-32 md:w-auto md:h-auto">
                <img src="{{ asset('assets/images/home_page/Frame 61.png') }}" alt=""
                    class="w-full h-full object-fit">
            </div>
        </div>

        <div class="container relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 text-text-white">Digital Commerce</h1>
            <p class="text-xl text-text-secondary mb-8 max-w-2xl mx-auto">The most reliable platform to buy and sell
                high-quality digital products.</p>

            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <div>
                    <x-ui.button class="py-2">
                        <flux:icon name="user"
                            class="w-5 h-5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                        {{ __('Explore Products') }}
                    </x-ui.button>
                </div>
                <div>
                    <x-ui.button class="py-2" variant='secondary'>
                        <flux:icon name="shopping-cart"
                            class="w-5 h-5 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                        {{ __('Sell Now') }}
                    </x-ui.button>
                </div>
            </div>
        </div>
    </section>
    <!-- Popular Games Section -->
    <section class="py-20">
        <div class="flex flex-wrap justify-center gap-4 p-6">
            <div
                class="group flex flex-col items-center justify-center w-32 h-32 rounded-2xl bg-bg-primary hover:bg-pink-500 transition-colors duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 stroke-text-text-white " fill="currentColor"
                    viewBox="0 0 256 256">
                    <path
                        d="M184,89.57V84c0-25.08-37.83-44-88-44S8,58.92,8,84v40c0,20.89,26.25,37.49,64,42.46V172c0,25.08,37.83,44,88,44s88-18.92,88-44V132C248,111.3,222.58,94.68,184,89.57ZM232,132c0,13.22-30.79,28-72,28-3.73,0-7.43-.13-11.08-.37C170.49,151.77,184,139,184,124V105.74C213.87,110.19,232,122.27,232,132ZM72,150.25V126.46A183.74,183.74,0,0,0,96,128a183.74,183.74,0,0,0,24-1.54v23.79A163,163,0,0,1,96,152,163,163,0,0,1,72,150.25Zm96-40.32V124c0,8.39-12.41,17.4-32,22.87V123.5C148.91,120.37,159.84,115.71,168,109.93ZM96,56c41.21,0,72,14.78,72,28s-30.79,28-72,28S24,97.22,24,84,54.79,56,96,56ZM24,124V109.93c8.16,5.78,19.09,10.44,32,13.57v23.37C36.41,141.4,24,132.39,24,124Zm64,48v-4.17c2.63.1,5.29.17,8,.17,3.88,0,7.67-.13,11.39-.35A121.92,121.92,0,0,0,120,171.41v23.46C100.41,189.4,88,180.39,88,172Zm48,26.25V174.4a179.48,179.48,0,0,0,24,1.6,183.74,183.74,0,0,0,24-1.54v23.79a165.45,165.45,0,0,1-48,0Zm64-3.38V171.5c12.91-3.13,23.84-7.79,32-13.57V172C232,180.39,219.59,189.4,200,194.87Z">
                    </path>
                </svg>
                <span class="text-text-white text-2xl font-medium">Currency</span>
            </div>
            {{-- Gift Card --}}
            <div
                class="group flex flex-col items-center justify-center w-32 h-32 rounded-2xl bg-bg-primary hover:bg-pink-500 transition-colors duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 stroke-text-text-white " fill="currentColor"
                    viewBox="0 0 256 256">
                    <path
                        d="M216,72H180.92c.39-.33.79-.65,1.17-1A29.53,29.53,0,0,0,192,49.57,32.62,32.62,0,0,0,158.44,16,29.53,29.53,0,0,0,137,25.91a54.94,54.94,0,0,0-9,14.48,54.94,54.94,0,0,0-9-14.48A29.53,29.53,0,0,0,97.56,16,32.62,32.62,0,0,0,64,49.57,29.53,29.53,0,0,0,73.91,71c.38.33.78.65,1.17,1H40A16,16,0,0,0,24,88v32a16,16,0,0,0,16,16v64a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V136a16,16,0,0,0,16-16V88A16,16,0,0,0,216,72ZM149,36.51a13.69,13.69,0,0,1,10-4.5h.49A16.62,16.62,0,0,1,176,49.08a13.69,13.69,0,0,1-4.5,10c-9.49,8.4-25.24,11.36-35,12.4C137.7,60.89,141,45.5,149,36.51Zm-64.09.36A16.63,16.63,0,0,1,96.59,32h.49a13.69,13.69,0,0,1,10,4.5c8.39,9.48,11.35,25.2,12.39,34.92-9.72-1-25.44-4-34.92-12.39a13.69,13.69,0,0,1-4.5-10A16.6,16.6,0,0,1,84.87,36.87ZM40,88h80v32H40Zm16,48h64v64H56Zm144,64H136V136h64Zm16-80H136V88h80v32Z">
                    </path>
                </svg>
                <span class="text-text-white text-2xl font-medium">Gift Card</span>
            </div>
            {{-- Boosting card --}}
            <div
                class="group flex flex-col items-center justify-center gap-2 w-32 h-32 rounded-2xl bg-bg-primary hover:bg-pink-500 transition-colors duration-300 cursor-pointer">
                <flux:icon name="rocket-launch" class="w-8 h-8" />
                <span class="text-text-white text-2xl font-medium">Boosting</span>
            </div>
            {{-- Items card --}}
            <div
                class="group flex flex-col items-center justify-center w-32 h-32 rounded-2xl bg-bg-primary hover:bg-pink-500 transition-colors duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 stroke-text-text-white" fill="currentColor"
                    viewBox="0 0 256 256">
                    <path
                        d="M245,110.64A16,16,0,0,0,232,104H216V88a16,16,0,0,0-16-16H130.67L102.94,51.2a16.14,16.14,0,0,0-9.6-3.2H40A16,16,0,0,0,24,64V208h0a8,8,0,0,0,8,8H211.1a8,8,0,0,0,7.59-5.47l28.49-85.47A16.05,16.05,0,0,0,245,110.64ZM93.34,64,123.2,86.4A8,8,0,0,0,128,88h72v16H69.77a16,16,0,0,0-15.18,10.94L40,158.7V64Zm112,136H43.1l26.67-80H232Z">
                    </path>
                </svg>
                <span class="text-text-white text-2xl font-medium">Items</span>
            </div>
            {{-- User card --}}
            <div
                class="group flex flex-col items-center justify-center w-32 h-32 rounded-2xl bg-bg-primary hover:bg-pink-500 transition-colors duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 stroke-text-text-white" fill="currentColor"
                    viewBox="0 0 256 256">
                    <path
                        d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z">
                    </path>
                </svg>
                <span class="text-text-white text-2xl font-medium">Accounts</span>
            </div>
            {{-- Top up card --}}
            <div
                class="group flex flex-col items-center justify-center w-32 h-32 rounded-2xl bg-bg-primary hover:bg-pink-500 transition-colors duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 stroke-text-text-white" fill="currentColor"
                    viewBox="0 0 256 256">
                    <path
                        d="M216,64H56a8,8,0,0,1,0-16H192a8,8,0,0,0,0-16H56A24,24,0,0,0,32,56V184a24,24,0,0,0,24,24H216a16,16,0,0,0,16-16V80A16,16,0,0,0,216,64Zm0,128H56a8,8,0,0,1-8-8V78.63A23.84,23.84,0,0,0,56,80H216Zm-48-60a12,12,0,1,1,12,12A12,12,0,0,1,168,132Z">
                    </path>
                </svg>
                <span class="text-text-white text-2xl font-medium">Top up</span>
            </div>
            {{-- Coacing card --}}
            <div
                class="group flex flex-col items-center justify-center w-32 h-32 rounded-2xl bg-bg-primary hover:bg-pink-500 transition-colors duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 stroke-text-text-white" fill="currentColor"
                    viewBox="0 0 256 256">
                    <path
                        d="M251.76,88.94l-120-64a8,8,0,0,0-7.52,0l-120,64a8,8,0,0,0,0,14.12L32,117.87v48.42a15.91,15.91,0,0,0,4.06,10.65C49.16,191.53,78.51,216,128,216a130,130,0,0,0,48-8.76V240a8,8,0,0,0,16,0V199.51a115.63,115.63,0,0,0,27.94-22.57A15.91,15.91,0,0,0,224,166.29V117.87l27.76-14.81a8,8,0,0,0,0-14.12ZM128,200c-43.27,0-68.72-21.14-80-33.71V126.4l76.24,40.66a8,8,0,0,0,7.52,0L176,143.47v46.34C163.4,195.69,147.52,200,128,200Zm80-33.75a97.83,97.83,0,0,1-16,14.25V134.93l16-8.53ZM188,118.94l-.22-.13-56-29.87a8,8,0,0,0-7.52,14.12L171,128l-43,22.93L25,96,128,41.07,231,96Z">
                    </path>
                </svg>
                <span class="text-text-white text-2xl font-medium">Coaching</span>
            </div>
        </div>

        <div class="container">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 text-text-white">Popular Games</h2>
                <p class="text-text-secondary">Find coins, items, and services for your favorite games.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Game Card 1 -->
                <div
                    class="bg-bg-primary border-[#1B0C33] rounded-lg p-8 text-align-center transition-all ease-[0.3s] backdrop-filter-blur-[10px]">
                    <div class="w-full max-w-[300px] mx-auto mb-4 rounded-lg flex items-center justify-center text-4xl">
                        <img src="{{ asset('assets/images/home_page/game-1.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-text-white">Blade Ball Tokens</h3>
                    <p class="text-sm text-text-secondary mb-4">50 items available</p>
                    <x-ui.button class="py-2!">
                        {{ __('Buy Now') }}
                    </x-ui.button>
                </div>

                <!-- Game Card 2 -->
                <div
                    class="bg-bg-primary border-[#1B0C33] rounded-lg p-8 text-align-center transition-all ease-[0.3s] backdrop-filter-blur-[10px]">
                    <div
                        class="w-full max-w-[300px] mx-auto mb-4  rounded-lg flex items-center justify-center text-4xl">
                        <img src="{{ asset('assets/images/home_page/game-2.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-text-white">Path Of Exile 2 Currency</h3>
                    <p class="text-sm text-text-secondary mb-4">50 items available</p>
                    <x-ui.button class="py-2!">
                        {{ __('Buy Now') }}
                    </x-ui.button>
                </div>

                <!-- Game Card 3 -->
                <div
                    class="bg-bg-primary border-[#1B0C33] rounded-lg p-8 text-align-center transition-all ease-[0.3s] backdrop-filter-blur-[10px]">
                    <div
                        class="w-full max-w-[300px] mx-auto mb-4  rounded-lg flex items-center justify-center text-4xl">
                        <img src="{{ asset('assets/images/home_page/game-3.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-text-white">RuneScape 3 Gold</h3>
                    <p class="text-sm text-text-secondary mb-4">50 items available</p>
                    <x-ui.button class="py-2!">
                        {{ __('Buy Now') }}
                    </x-ui.button>
                </div>

                <!-- Game Card 4 -->
                <div
                    class="bg-bg-primary border-[#1B0C33] rounded-lg p-8 text-align-center transition-all ease-[0.3s] backdrop-filter-blur-[10px]">
                    <div class="w-full max-w-[300px] mx-auto mb-4 rounded-lg flex items-center justify-center text-4xl">
                        <img src="{{ asset('assets/images/home_page/game-4.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-text-white">New World Coins</h3>
                    <p class="text-sm text-text-secondary mb-4">50 items available</p>
                    <x-ui.button class="py-2!">
                        {{ __('Buy Now') }}
                    </x-ui.button>
                </div>

                <!-- Game Card 5 -->
                <div
                    class="bg-bg-primary border-[#1B0C33] rounded-lg p-8 text-align-center transition-all ease-[0.3s] backdrop-filter-blur-[10px]">
                    <div class="w-full max-w-[300px] mx-auto mb-4 rounded-lg flex items-center justify-center text-4xl">
                        <img src="{{ asset('assets/images/home_page/game-5.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-text-white">Lost Ark Gold</h3>
                    <p class="text-sm text-text-secondary mb-4">50 items available</p>
                    <x-ui.button class="py-2!">
                        {{ __('Buy Now') }}
                    </x-ui.button>
                </div>

                <!-- Game Card 6 -->
                <div
                    class="bg-bg-primary border-[#1B0C33] rounded-lg p-8 text-align-center transition-all ease-[0.3s] backdrop-filter-blur-[10px]">
                    <div
                        class="w-full max-w-[300px] mx-auto mb-4 rounded-lg flex items-center justify-center text-4xl">
                        <img src="{{ asset('assets/images/home_page/game-6.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-text-white">Old School RuneScape Gold</h3>
                    <p class="text-sm text-text-secondary mb-4">50 items available</p>
                    <x-ui.button class="py-2!">
                        {{ __('Buy Now') }}
                    </x-ui.button>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20">
        <div class="container">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 text-text-white">How It Works</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-bg-primary rounded-xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        <img src="{{ asset('assets/images/home_page/secure_transaction.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-text-white">Secure Transactions</h3>
                    <p class="text-text-secondary text-sm">Our platform uses industry-leading encryption to ensure your
                        transactions are safe and secure, guaranteeing a safe shopping experience.</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center relative">
                    <div
                        class="w-20 h-20 bg-[rgba(133,62,255,0.1)] rounded-xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        <img src="{{ asset('assets/images/home_page/verified_sellers.png') }}" alt="">
                    </div>
                    <div class="absolute top-1/4 -left-1/4 z-20 hidden md:block">
                        <img src="{{ asset('assets/images/home_page/right-arrow.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-text-white">Verified Sellers</h3>
                    <p class="text-text-secondary text-sm">We meticulously verify each seller to ensure you receive
                        genuine digital goods from trusted sources.</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center relative">
                    <div
                        class="w-20 h-20 bg-[rgba(133,62,255,0.1)] rounded-xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        <img src="{{ asset('assets/images/home_page/effortless_buying.png') }}" alt="">
                    </div>
                    <div class="absolute top-1/4 -left-1/4 z-20 hidden md:block">
                        <img src="{{ asset('assets/images/home_page/right-arrow.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-text-white">Effortless Buying & Selling</h3>
                    <p class="text-text-secondary text-sm">Our intuitive platform streamlines the buying and selling
                        process, set with quick delivery and software within reach.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="py-20 bg-gradient-to-r from-[#5f3fbc]  to-[#50072c]">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold mb-6 text-white">About us</h2>
                    <p class="text-white/70 mb-4">Digital Commerce is your go-to destination for buying and selling
                        high-quality digital products. We connect buyers and verified sellers, ensuring secure
                        transactions, fast delivery, and dedicated support for a seamless experience.</p>
                    {{-- <button class="btn-primary">
                        <span><x-flux::icon name="user" class="w-6 h-6 inline-block" stroke="white" /></span>
                        Explore Products</button> --}}
                    <x-ui.button class="w-52! py-2">
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
    <section class="py-20 bg-bg-secondary">
        <div class="container py-8" x-data="{ active: 0, tab: 'buyers' }">

            <h2 class="text-text-white text-center text-[40px] mb-6 font-semibold">Frequently Asked Questions</h2>

            <!-- Tabs -->
            <div class="max-w-xs mx-auto flex justify-between mb-8 bg-bg-primary rounded-full px-4 py-3">
                <button @click="tab = 'buyers'; active = 0"
                    :class="tab === 'buyers' ? 'bg-purple-700 px-5 py-3 rounded-full shadow-lg text-white' :
                        'text-text-secondery px-7'"
                    class="transition-colors duration-300 font-medium">
                    For Buyers
                </button>
                <button @click="tab = 'sellers'; active = 0"
                    :class="tab === 'sellers' ? 'bg-purple-700 px-5 py-3 rounded-full shadow-lg text-white' :
                        'text-text-secondery px-7'"
                    class="transition-colors duration-300 font-medium">
                    For Sellers
                </button>
            </div>

            <!-- FAQ Items for Buyers -->
            <template x-if="tab === 'buyers'">
                <div class="space-y-4">

                    <!-- Buyer FAQ Items -->
                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 0 ? active = null : active = 0">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">How do I buy a product?</h3>
                            <svg :class="active === 0 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 0" x-transition class="mt-2 text-text-secondery text-sm">
                            Browse or search for your desired digital product. Click on the product, review the
                            details,
                            click "Buy Now," proceed to checkout, and select your preferred payment method.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 1 ? active = null : active = 1">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">What payment methods are accepted?</h3>
                            <svg :class="active === 1 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 1" x-transition class="mt-2 text-text-secondery text-sm">
                            We accept various payment methods including credit cards, PayPal, and more.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 2 ? active = null : active = 2">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">What is the buyer protection policy?</h3>
                            <svg :class="active === 2 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 2" x-transition class="mt-2 text-text-secondery text-sm">
                            Our buyer protection policy ensures secure transactions and support for any disputes.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 3 ? active = null : active = 3">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">How do I receive my purchased digital product?
                            </h3>
                            <svg :class="active === 3 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 3" x-transition class="mt-2 text-text-secondery text-sm">
                            After purchase, you will receive a download link or access instructions via email.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 4 ? active = null : active = 4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">What if the seller doesn't deliver the product?
                            </h3>
                            <svg :class="active === 4 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 4" x-transition class="mt-2 text-text-secondery text-sm">
                            Contact support immediately and we will assist you with dispute resolution.
                        </p>
                    </div>

                </div>
            </template>

            <!-- FAQ Items for Sellers -->
            <template x-if="tab === 'sellers'">
                <div class="space-y-4">

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 0 ? active = null : active = 0">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">How do I become a seller?</h3>
                            <svg :class="active === 0 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 0" x-transition class="mt-2 text-text-secondery text-sm">
                            Click "Start Selling" or register an account and navigate to the seller dashboard. You
                            will
                            need to complete our seller verification process, which includes providing personal
                            information and an ID document.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 1 ? active = null : active = 1">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">Why do I need to be verified to sell?</h3>
                            <svg :class="active === 1 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 1" x-transition class="mt-2 text-text-secondery text-sm">
                            Verification helps us ensure the authenticity and trustworthiness of sellers on our
                            platform.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 2 ? active = null : active = 2">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">What kind of digital products can I sell?</h3>
                            <svg :class="active === 2 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 2" x-transition class="mt-2 text-text-secondery text-sm">
                            You can sell ebooks, music, software, design files, and other digital goods.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 3 ? active = null : active = 3">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">How do I list a product?</h3>
                            <svg :class="active === 3 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 3" x-transition class="mt-2 text-text-secondery text-sm">
                            Register your product on the seller dashboard by providing the required details and
                            uploading your files.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 4 ? active = null : active = 4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">How do I get paid?</h3>
                            <svg :class="active === 4 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 4" x-transition class="mt-2 text-text-secondery text-sm">
                            Payments are processed securely via the platform, and funds are transferred according to
                            your selected payout method.
                        </p>
                    </div>

                </div>
            </template>
        </div>
    </section>
</main>
