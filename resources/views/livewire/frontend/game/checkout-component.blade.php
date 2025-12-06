<div class="mx-auto">
    <form action="#">
        <div class="container mx-auto">
            <div class="flex items-center gap-2 my-8 text-lg font-semibold">
                <div class="w-4 h-4">
                    <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
                </div>
                <h1 class="text-blue-100 text-text-primary">
                    {{ ucwords(str_replace('-', ' ', $gameSlug)) . ' ' . ucwords(str_replace('-', ' ', $categorySlug)) }}
                </h1>
                <span class=" text-text-primary">></span>
                <span class=" text-text-primary">Checkout</span>
            </div>
            <div class="flex flex-col md:flex-row gap-6">
                <div class="w-full">
                    <div class="p-4 md:p-10 bg-bg-primary rounded-2xl">
                        <h2 class="text-text-white text-2xl font-semibold mb-6">{{ __('Product info') }}</h2>
                        <div class="flex gap-6 items-start">
                            <!-- Image -->
                            <div class="w-14 h-14 shrink-0">
                                <img src="{{ asset('assets/images/sports.png') }}" alt="V-Bucks"
                                    class="w-full h-full object-contain">
                            </div>
                            <!-- Text Content -->
                            <div class="flex-1">
                                <!-- Title + Description -->
                                <h2 class="text-text-white text-xl font-normal leading-relaxed">
                                    <span class="font-bold">{{ __('EA sports FC Coins') }}</span>
                                    {{ __(' Fast, cheap pro boost. Any brawler, any trophies. DM now!') }}
                                </h2>

                                <!-- Category -->
                                <span class="text-text-white text-sm block mt-1">
                                    {{ __('Brawl Stars - Boosting') }}
                                </span>

                                <!-- Quantity + Price -->
                                <div class="flex justify-end items-center gap-8 mt-5">
                                    <h3 class="text-text-white text-xl">*1</h3>
                                    <h3 class="text-text-white text-2xl font-semibold">$776.28</h3>
                                </div>
                            </div>
                        </div>
                        <!-- Divider -->
                        <span class="block border-t border-zinc-500 mt-6"></span>
                    </div>
                </div>
            </div>
        </div>
        {{-- payment methoad --}}
        {{-- <div class="container mx-auto mt-10 mb-40">
            <div class="bg-bg-primary md:p-10 rounded-2xl">
                <h2 class="text-text-white text-2xl font-semibold mb-6">{{ __('Payment method') }}</h2>
                <div class="#">
                    <form action="#">
                        <div
                            class="flex items-center justify-between gap-4 border border-zinc-500 rounded-2xl py-5 px-6">
                            <div class="flex items-center gap-2">
                                <div class="w-12 h-5">
                                    <img src="{{ asset('assets/images/gift_cards/Visa.png') }}" alt=""
                                        class="w-full h-full">
                                </div>
                                <div class="w-5 h-5">
                                    <img src="{{ asset('assets/images/gift_cards/mastercard.png') }}" alt=""
                                        class="w-full h-full">
                                </div>
                                <div class="w-5 h-5">
                                    <img src="{{ asset('assets/images/gift_cards/Frame 1261154336.png') }}"
                                        alt="" class="w-full h-full">
                                </div>
                                <div class="w-5 h-5">
                                    <img src="{{ asset('assets/images/gift_cards/a.png') }}" alt=""
                                        class="w-full h-full">
                                </div>
                                <div class="w-16 h-5">
                                    <img src="{{ asset('assets/images/gift_cards/Frame 1 (1).png') }}" alt=""
                                        class="w-full h-full">
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <p class="text-text-white hidden md:block">{{ __('Credit/Debit Card') }}</p>
                                <input type="radio" name="" id=""
                                    class="scale-150 accent-zinc-500 rounded-full">
                            </div>
                        </div>

                        <div class="form-group ">
                            <x-ui.input placeholder="{{ __('Card number*') }}"
                                class="mt-6 dark:bg-bg-black! placeholder-text-white!" />
                        </div>

                        <div class="form-group">
                            <x-ui.input placeholder="{{ __('Card number*') }}"
                                class="mt-6 dark:bg-bg-black! placeholder-text-white!" />
                        </div>

                        <div class="flex items-center justify-between gap-6">
                            <div class="form-group w-full">
                                <x-ui.input placeholder="{{ __('vali date*') }}"
                                    class="mt-6 dark:bg-bg-black! placeholder-text-white!" />
                            </div>

                            <div class="form-group w-full">
                                <x-ui.input placeholder="{{ __('CVC*') }}"
                                    class="mt-6 dark:bg-bg-black! text-text-white placeholder-text-white!" />
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between gap-4 border border-zinc-500 rounded-2xl py-5 px-6 mt-6">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6">
                                    <img src="{{ asset('assets/images/gift_cards/Crypto1.png') }}" alt=""
                                        class="w-full h-full">
                                </div>
                                <div class="w-6 h-6">
                                    <img src="{{ asset('assets/images/gift_cards/Crypto2.png') }}" alt=""
                                        class="w-full h-full">
                                </div>
                                <div class="w-6 h-6">
                                    <img src="{{ asset('assets/images/gift_cards/Crypto3.png') }}" alt=""
                                        class="w-full h-full">
                                </div>
                                <div class="w-6 h-6">
                                    <img src="{{ asset('assets/images/gift_cards/Crypto4.png') }}" alt=""
                                        class="w-full h-full">
                                </div>
                                <div class="w-6 h-6">
                                    <img src="{{ asset('assets/images/gift_cards/Crypto4.png') }}" alt=""
                                        class="w-full h-full">
                                </div>
                            </div>
                            <div class="flex items-center gap-4 ">
                                <p class="text-text-white hidden md:block">{{ __('Crypto') }}</p>
                                <input type="radio" name="" id=""
                                    class="scale-150 accent-zinc-500 rounded-full">
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between gap-4 border border-zinc-500 rounded-2xl py-5 px-6 mt-6">
                            <div class="flex items-center gap-2">
                                <div class="w-11 h-7">
                                    <img src="{{ asset('assets/images/gift_cards/google2.png') }}" alt=""
                                        class="w-full h-full">
                                </div>
                                <div class="w-11 h-7">
                                    <img src="{{ asset('assets/images/gift_cards/apple2.png') }}" alt=""
                                        class="w-full h-full">
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <p class="text-text-white hidden md:block">{{ __('Digital Wallet') }}</p>
                                <input type="radio" name="" id=""
                                    class="scale-150 accent-zinc-500 rounded-full">
                            </div>

                        </div>

                    </form>
                </div>
            </div>

            <div class="w-full bg-bg-primary py-7 px-6 rounded-2xl mt-8">
                <div class="mb-3">
                    <h2 class="text-2xl font-semibold">{{ __('Cart Total') }}</h2>
                </div>
                <div class="flex justify-between mb-3">
                    <p class="text-text-white text-sm">{{ __('Cart Subtotal') }}</p>
                    <p class="text-text-white text-base font-semibold">$776.28</p>
                </div>
                <div class="flex justify-between  mb-3">
                    <p class="text-text-white text-sm">{{ __('Payment fee') }}</p>
                    <p class="text-text-white text-base font-semibold">+0.79</p>
                </div>
                <div class="flex justify-between  mb-3">
                    <p class="text-text-white text-sm">{{ __('Discount') }}</p>
                    <p class="text-text-white text-base font-semibold">-$00</p>
                </div>
                <div class="flex justify-between  mb-3">
                    <p class="text-text-white text-sm">{{ __('Cart Total') }}</p>
                    <p class="text-text-white text-base font-semibold">$777.07</p>
                </div>
                <div class="mt-8 lg:px-78 px-0">
                    <x-ui.button href="{{ route('game.checkout', ['orderId' => 435345]) }}"
                        class="w-auto py-3!">{{ __('$76.28 | Buy now') }}
                    </x-ui.button>
                </div>
                <div class="mt-8">
                    <input type="checkbox" name="" id="" class="accent-zinc-500 rounded-full">
                    <label for=""
                        class="text-text-white text-base ">{{ __('I accept the Terms of Service , Privacy Notice and Refund Policy.') }}</label>
                </div>
            </div>
        </div> --}}

        <div class="container mx-auto mt-10 mb-40" x-data="{ selectedPayment: '' }">
            <div class="bg-bg-primary md:p-10 rounded-2xl">
                <h2 class="text-text-white text-2xl font-semibold mb-6">{{ __('Payment method') }}</h2>

                <form action="#">

                    <!-- Credit/Debit Card -->
                    <div :class="{ 'border-blue-500': selectedPayment === 'credit_card' }"
                        class="flex items-center justify-between gap-4 border border-zinc-700 rounded py-4 px-6 cursor-pointer"
                        @click="selectedPayment = 'credit_card'">
                        <div class="flex items-center gap-2">
                            <div class="w-12 h-5"><img src="{{ asset('assets/images/gift_cards/Visa.png') }}"
                                    class="w-full h-full"></div>
                            <div class="w-5 h-5"><img src="{{ asset('assets/images/gift_cards/mastercard.png') }}"
                                    class="w-full h-full"></div>
                            <div class="w-5 h-5"><img
                                    src="{{ asset('assets/images/gift_cards/Frame 1261154336.png') }}"
                                    class="w-full h-full"></div>
                            <div class="w-5 h-5"><img src="{{ asset('assets/images/gift_cards/a.png') }}"
                                    class="w-full h-full"></div>
                            <div class="w-16 h-5"><img src="{{ asset('assets/images/gift_cards/Frame 1 (1).png') }}"
                                    class="w-full h-full"></div>
                        </div>

                        <div class="flex items-center gap-4">
                            <p class="text-text-white hidden md:block">{{ __('Credit/Debit Card') }}</p>

                            <label class="relative cursor-pointer select-none flex items-center group">
                                <!-- REAL RADIO (hidden but still active) -->
                                <input type="radio" name="payment_method" value="credit_card"
                                    x-model="selectedPayment" class="sr-only" />

                                <!-- CUSTOM CIRCLE -->
                                <span
                                    class="w-6 h-6 flex items-center justify-center rounded-full border border-zinc-700 transition-all duration-200 group-has-[:checked]:bg-zinc-700 group-has-[:checked]:border-zinc-700">
                                    <!-- CHECK ICON -->
                                    <svg class="w-4 h-4 text-white opacity-0 group-has-[:checked]:opacity-100 transition-opacity duration-200"
                                        fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </label>
                        </div>

                    </div>

                    <!-- Credit/Debit Card Form -->
                    <div x-show="selectedPayment === 'credit_card'" class="mt-6 space-y-4">
                        <x-ui.input placeholder="{{ __('Card number*') }}"
                            class="dark:bg-bg-black! placeholder-text-white! border-0! " />
                        <x-ui.input placeholder="{{ __('Card number*') }}"
                            class="dark:bg-bg-black! placeholder-text-white! border-0! " />
                        <div class="flex gap-6">
                            <x-ui.input placeholder="{{ __('Valid date*') }}"
                                class="w-full dark:bg-bg-black! placeholder-text-white! border-0!" />
                            <x-ui.input placeholder="{{ __('CVC*') }}"
                                class="w-full dark:bg-bg-black! placeholder-text-white! border-0!" />
                        </div>
                    </div>

                    <!-- Digital Wallet -->
                    <div :class="{ 'border-blue-500': selectedPayment === 'digital_wallet' }"
                        class="flex items-center justify-between gap-4 border border-zinc-500 rounded py-4 px-6 mt-6 cursor-pointer"
                        @click="selectedPayment = 'digital_wallet'">
                        <div class="flex items-center gap-2">
                            <div class="w-11 h-7"><img src="{{ asset('assets/images/gift_cards/google2.png') }}"
                                    class="w-full h-full"></div>
                            <div class="w-11 h-7"><img src="{{ asset('assets/images/gift_cards/apple2.png') }}"
                                    class="w-full h-full"></div>
                        </div>
                        {{-- <div class="flex items-center gap-4">
                            <p class="text-text-white hidden md:block">{{ __(' Digital Wallet') }}</p>
                            <input type="radio" name="payment_method" value="digital_wallet" x-model="selectedPayment"
                                class="scale-150 accent-zinc-500 rounded-full">
                        </div> --}}

                        <div class="flex items-center gap-4">
                            <p class="text-text-white hidden md:block">{{ __('Digital Wallet') }}</p>

                            <label class="relative cursor-pointer select-none flex items-center group rounded-full!">
                                <!-- REAL RADIO (hidden but still active) -->
                                <input type="radio" name="payment_method" value="digital_wallet"
                                    x-model="selectedPayment" class="sr-only" />

                                <!-- CUSTOM CIRCLE -->
                                <span
                                    class="w-6 h-6 flex items-center rounded-full justify-center rounded border border-zinc-700 transition-all duration-200 group-has-[:checked]:bg-zinc-700 group-has-[:checked]:border-zinc-700">
                                    <!-- CHECK ICON -->
                                    <svg class="w-4 h-4 text-white opacity-0 group-has-[:checked]:opacity-100 transition-opacity duration-200"
                                        fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Digital Wallet Form -->
                    <div x-show="selectedPayment === 'digital_wallet'" class="mt-6">
                        <p class="text-text-white">{{ __('You have selected Digital Wallet payment method.') }}</p>
                    </div>

                    <!-- Crypto Wallet -->
                    <div :class="{ 'border-blue-500': selectedPayment === 'crypto' }"
                        class="flex items-center justify-between gap-4 border border-zinc-500 rounded py-4 px-6 mt-6 cursor-pointer"
                        @click="selectedPayment = 'crypto'">
                        <div class="flex items-center gap-2">

                            <div class="w-6 h-6"><img src="{{ asset('assets/images/gift_cards/Crypto1.png') }}"
                                    class="w-full h-full"></div>
                            <div class="w-6 h-6"><img src="{{ asset('assets/images/gift_cards/Crypto2.png') }}"
                                    class="w-full h-full"></div>
                            <div class="w-6 h-6"><img src="{{ asset('assets/images/gift_cards/Crypto3.png') }}"
                                    class="w-full h-full"></div>
                            <div class="w-6 h-6"><img src="{{ asset('assets/images/gift_cards/Crypto4.png') }}"
                                    class="w-full h-full"></div>
                            <div class="w-6 h-6"><img src="{{ asset('assets/images/gift_cards/Crypto4.png') }}"
                                    class="w-full h-full"></div>
                        </div>
                        {{-- <div class="flex items-center gap-4">
                            <p class="text-text-white hidden md:block">{{ __('Crypto') }}</p>
                            <input type="radio" name="payment_method" value="crypto" x-model="selectedPayment"
                                class="scale-150 accent-zinc-500 rounded-full">
                        </div> --}}

                        <div class="flex items-center gap-4">
                            <p class="text-text-white hidden md:block">{{ __('Crypto') }}</p>

                            <label class="relative cursor-pointer select-none flex items-center group">
                                <!-- REAL RADIO (hidden but still active) -->
                                <input type="radio" name="payment_method" value="crypto" x-model="selectedPayment"
                                    class="sr-only" />

                                <!-- CUSTOM CIRCLE -->
                                <span
                                    class="w-6 h-6 flex items-center justify-center rounded-full border border-zinc-700 transition-all duration-200 group-has-[:checked]:bg-zinc-700 group-has-[:checked]:border-zinc-700">
                                    <!-- CHECK ICON -->
                                    <svg class="w-4 h-4 text-white opacity-0 group-has-[:checked]:opacity-100 transition-opacity duration-200"
                                        fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Crypto Form -->
                    <div x-show="selectedPayment === 'crypto'" class="mt-6">
                        <p class="text-text-white">{{ __('You have selected Crypto payment method.') }}</p>
                    </div>

                </form>
            </div>

            <!-- Cart Total -->
            <div class="w-full bg-bg-primary py-7 px-6 rounded-2xl mt-8">
                <div class="mb-3">
                    <h2 class="text-2xl font-semibold">{{ __('Cart Total') }}</h2>
                </div>
                <div class="flex justify-between mb-3">
                    <p class="text-text-white text-sm">{{ __('Cart Subtotal') }}</p>
                    <p class="text-text-white text-base font-semibold">$776.28</p>
                </div>
                <div class="flex justify-between mb-3">
                    <p class="text-text-white text-sm">{{ __('Payment fee') }}</p>
                    <p class="text-text-white text-base font-semibold">+0.79</p>
                </div>
                <div class="flex justify-between mb-3">
                    <p class="text-text-white text-sm">{{ __('Discount') }}</p>
                    <p class="text-text-white text-base font-semibold">-$00</p>
                </div>
                <div class="flex justify-between mb-3">
                    <p class="text-text-white text-sm">{{ __('Cart Total') }}</p>
                    <p class="text-text-white text-base font-semibold">$777.07</p>
                </div>

                <div class="mt-8">


                    <label class="relative cursor-pointer select-none flex items-center group ">
                        <!-- REAL RADIO (hidden but still active) -->
                        <input type="radio" name="payment_method" value="digital_wallet" x-model="selectedPayment"
                            class="sr-only " />

                        <!-- CUSTOM CIRCLE -->
                        <span
                            class="w-6 h-6 flex items-center justify-center rounded-full! border border-zinc-700 transition-all duration-200 group-has-[:checked]:bg-zinc-700 group-has-[:checked]:border-zinc-700">
                            <!-- CHECK ICON -->
                            <svg class="w-6 h-6 text-white opacity-0 group-has-[:checked]:opacity-100 transition-opacity duration-200"
                                fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        {{-- <input type="checkbox" name="" id="" class="accent-zinc-500 rounded-full"> --}}
                        <label class="text-text-white text-base px-2">
                            {{ __('I accept the Terms of Service, Privacy Notice and Refund Policy.') }}

                        </label>
                    </label>
                </div>


                 <div class="mt-8 lg:px-78 px-0">
                    <x-ui.button href="{{ route('game.checkout', ['orderId' => 435345]) }}" class="w-auto py-3!">
                        {{ __('$76.28 | Buy now') }}
                    </x-ui.button>
                </div>
            </div>
        </div>

        <!-- Don't forget to include Alpine.js -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    </form>
</div>
