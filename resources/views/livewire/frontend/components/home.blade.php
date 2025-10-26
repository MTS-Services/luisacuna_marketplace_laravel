<main class="overflow-x-hidden-hidden">
    <!-- Hero Section -->
    <section class=" relative py-20 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-gradient-to-r from-purple-950 via-black to-purple-950">
            <div class="absolute top-50 -translate-y-1/2 left-0">
                <img src="{{ asset('assets/images/home_page/Frame 62.png') }}" alt="">
            </div>

            <div class="absolute top-50 translate-y-[-50%] right-0 z-10">
                <img src="{{ asset('assets/images/home_page/Frame 61.png') }}" alt="">
            </div>
        </div>

        <div class=" relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 text-white">Digital Commerce</h1>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">The most reliable platform to buy and sell high-quality digital products.</p>

            <div class="flex gap-4 justify-center flex-wrap">
                <button class="btn-primary">
                    <span><x-flux::icon name="user" class="w-6 h-6 inline-block" stroke="white" /></span>
                    Explore Products</button>
                <button class="btn-secondary"><span><x-flux::icon name="shopping-cart" class="w-5 h-5 inline-block stroke-zinc-500" />
                    </span> Sell Now</button>
            </div>
        </div>
    </section>

    <!-- Popular Games Section -->
    <section class="py-20">
        <div class="max-w-7xl  mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 text-white">Popular Games</h2>
                <p class="text-gray-400">Find coins, items, and services for your favorite games.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Game Card 1 -->
                <div
                    class="bg-[#1B0C33] border-[#1B0C33] rounded-lg p-8 text-align-center transition-all ease-[0.3s] backdrop-filter-blur-[10px]">
                    <div class="w-full max-w-[300px] mx-auto mb-4 rounded-lg flex items-center justify-center text-4xl">
                        <img src="{{ asset('assets/images/home_page/game-1.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">Blade Ball Tokens</h3>
                    <p class="text-sm text-gray-400 mb-4">50 items available</p>
                    <button class="btn-primary w-full">Buy Now</button>
                </div>

                <!-- Game Card 2 -->
                <div
                    class="bg-[#1B0C33] border-[#1B0C33] rounded-lg p-8 text-align-center transition-all ease-[0.3s] backdrop-filter-blur-[10px]">
                    <div
                        class="w-full max-w-[300px] mx-auto mb-4  rounded-lg flex items-center justify-center text-4xl">
                        <img src="{{ asset('assets/images/home_page/game-2.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">Path Of Exile 2 Currency</h3>
                    <p class="text-sm text-gray-400 mb-4">50 items available</p>
                    <button class="btn-primary w-full">Buy Now</button>
                </div>

                <!-- Game Card 3 -->
                <div
                    class="bg-[#1B0C33] border-[#1B0C33] rounded-lg p-8 text-align-center transition-all ease-[0.3s] backdrop-filter-blur-[10px]">
                    <div
                        class="w-full max-w-[300px] mx-auto mb-4  rounded-lg flex items-center justify-center text-4xl">
                        <img src="{{ asset('assets/images/home_page/game-3.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">RuneScape 3 Gold</h3>
                    <p class="text-sm text-gray-400 mb-4">50 items available</p>
                    <button class="btn-primary w-full">Buy Now</button>
                </div>

                <!-- Game Card 4 -->
                <div
                    class="bg-[#1B0C33] border-[#1B0C33] rounded-lg p-8 text-align-center transition-all ease-[0.3s] backdrop-filter-blur-[10px]">
                    <div class="w-full max-w-[300px] mx-auto mb-4 rounded-lg flex items-center justify-center text-4xl">
                        <img src="{{ asset('assets/images/home_page/game-4.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">New World Coins</h3>
                    <p class="text-sm text-gray-400 mb-4">50 items available</p>
                    <button class="btn-primary w-full">Buy Now</button>
                </div>

                <!-- Game Card 5 -->
                <div
                    class="bg-[#1B0C33] border-[#1B0C33] rounded-lg p-8 text-align-center transition-all ease-[0.3s] backdrop-filter-blur-[10px]">
                    <div class="w-full max-w-[300px] mx-auto mb-4 rounded-lg flex items-center justify-center text-4xl">
                        <img src="{{ asset('assets/images/home_page/game-5.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">Lost Ark Gold</h3>
                    <p class="text-sm text-gray-400 mb-4">50 items available</p>
                    <button class="btn-primary w-full">Buy Now</button>
                </div>

                <!-- Game Card 6 -->
                <div
                    class="bg-[#1B0C33] border-[#1B0C33] rounded-lg p-8 text-align-center transition-all ease-[0.3s] backdrop-filter-blur-[10px]">
                    <div class="w-full max-w-[300px] mx-auto mb-4 rounded-lg flex items-center justify-center text-4xl">
                        <img src="{{ asset('assets/images/home_page/game-6.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">Old School RuneScape Gold</h3>
                    <p class="text-sm text-gray-400 mb-4">50 items available</p>
                    <button class="btn-primary w-full">Buy Now</button>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20">
        <div class="max-w-7xl  mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 text-white">How It Works</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="icon-box">
                        <img src="{{ asset('assets/images/home_page/secure_transaction.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">Secure Transactions</h3>
                    <p class="text-gray-400 text-sm">Our platform uses industry-leading encryption to ensure your
                        transactions are safe and secure, guaranteeing a safe shopping experience.</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center relative">
                    <div class="icon-box">
                        <img src="{{ asset('assets/images/home_page/verified_sellers.png') }}" alt="">
                    </div>
                    <div class="absolute top-1/4 -left-1/4 z-20">
                        <img src="{{ asset('assets/images/home_page/right-arrow.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">Verified Sellers</h3>
                    <p class="text-gray-400 text-sm">We meticulously verify each seller to ensure you receive
                        genuine digital goods from trusted sources.</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center relative">
                    <div class="icon-box">
                        <img src="{{ asset('assets/images/home_page/effortless_buying.png') }}" alt="">
                    </div>
                    <div class="absolute top-1/4 -left-1/4 z-20">
                        <img src="{{ asset('assets/images/home_page/right-arrow.png') }}" alt="">
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">Effortless Buying & Selling</h3>
                    <p class="text-gray-400 text-sm">Our intuitive platform streamlines the buying and selling
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
                    <p class="text-gray-300 mb-4">Digital Commerce is your go-to destination for buying and selling
                        high-quality digital products. We connect buyers and verified sellers, ensuring secure
                        transactions, fast delivery, and dedicated support for a seamless experience.</p>
                    <button class="btn-primary">
                        <span><x-flux::icon name="user" class="w-6 h-6 inline-block" stroke="white" /></span>
                        Explore Products</button>
                </div>

                <div class="w-full h-full">
                    <img src="{{ asset('assets/images/home_page/about.png') }}" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20">
        <div class="container py-8  bg-black/50" x-data="{ active: 0, tab: 'buyers' }">

            <h2 class="text-white text-center text-[40px] mb-6 font-semibold">Frequently Asked Questions</h2>

            <!-- Tabs -->
            <div class="max-w-xs mx-auto flex justify-between mb-8 bg-bg-primary rounded-full px-4 py-3">
                <button @click="tab = 'buyers'; active = 0"
                    :class="tab === 'buyers' ? 'bg-purple-700 px-5 py-3 rounded-full shadow-lg text-white' :
                        'text-gray-300 px-7'"
                    class="transition-colors duration-300 font-medium">
                    For Buyers
                </button>
                <button @click="tab = 'sellers'; active = 0"
                    :class="tab === 'sellers' ? 'bg-purple-700 px-5 py-3 rounded-full shadow-lg text-white' :
                        'text-gray-300 px-7'"
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
                            <h3 class="text-white font-semibold">How do I buy a product?</h3>
                            <svg :class="active === 0 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-white transition-transform" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 0" x-transition class="mt-2 text-gray-300 text-sm">
                            Browse or search for your desired digital product. Click on the product, review the
                            details,
                            click "Buy Now," proceed to checkout, and select your preferred payment method.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 1 ? active = null : active = 1">
                        <div class="flex justify-between items-center">
                            <h3 class="text-white font-semibold">What payment methods are accepted?</h3>
                            <svg :class="active === 1 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-white transition-transform" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 1" x-transition class="mt-2 text-gray-300 text-sm">
                            We accept various payment methods including credit cards, PayPal, and more.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 2 ? active = null : active = 2">
                        <div class="flex justify-between items-center">
                            <h3 class="text-white font-semibold">What is the buyer protection policy?</h3>
                            <svg :class="active === 2 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-white transition-transform" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 2" x-transition class="mt-2 text-gray-300 text-sm">
                            Our buyer protection policy ensures secure transactions and support for any disputes.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 3 ? active = null : active = 3">
                        <div class="flex justify-between items-center">
                            <h3 class="text-white font-semibold">How do I receive my purchased digital product?
                            </h3>
                            <svg :class="active === 3 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-white transition-transform" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 3" x-transition class="mt-2 text-gray-300 text-sm">
                            After purchase, you will receive a download link or access instructions via email.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 4 ? active = null : active = 4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-white font-semibold">What if the seller doesn't deliver the product?
                            </h3>
                            <svg :class="active === 4 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-white transition-transform" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 4" x-transition class="mt-2 text-gray-300 text-sm">
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
                            <h3 class="text-white font-semibold">How do I become a seller?</h3>
                            <svg :class="active === 0 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-white transition-transform" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 0" x-transition class="mt-2 text-gray-300 text-sm">
                            Click "Start Selling" or register an account and navigate to the seller dashboard. You
                            will
                            need to complete our seller verification process, which includes providing personal
                            information and an ID document.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 1 ? active = null : active = 1">
                        <div class="flex justify-between items-center">
                            <h3 class="text-white font-semibold">Why do I need to be verified to sell?</h3>
                            <svg :class="active === 1 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-white transition-transform" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 1" x-transition class="mt-2 text-gray-300 text-sm">
                            Verification helps us ensure the authenticity and trustworthiness of sellers on our
                            platform.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 2 ? active = null : active = 2">
                        <div class="flex justify-between items-center">
                            <h3 class="text-white font-semibold">What kind of digital products can I sell?</h3>
                            <svg :class="active === 2 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-white transition-transform" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 2" x-transition class="mt-2 text-gray-300 text-sm">
                            You can sell ebooks, music, software, design files, and other digital goods.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 3 ? active = null : active = 3">
                        <div class="flex justify-between items-center">
                            <h3 class="text-white font-semibold">How do I list a product?</h3>
                            <svg :class="active === 3 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-white transition-transform" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 3" x-transition class="mt-2 text-gray-300 text-sm">
                            Register your product on the seller dashboard by providing the required details and
                            uploading your files.
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 4 ? active = null : active = 4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-white font-semibold">How do I get paid?</h3>
                            <svg :class="active === 4 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-white transition-transform" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 4" x-transition class="mt-2 text-gray-300 text-sm">
                            Payments are processed securely via the platform, and funds are transferred according to
                            your selected payout method.
                        </p>
                    </div>

                </div>
            </template>
        </div>
    </section>
</main>
