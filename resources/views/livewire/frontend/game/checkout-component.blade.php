<div class="mx-auto bg-page">
    <form action="#">
        <div class="container mx-auto">
            <div class="flex items-center gap-2 my-8 text-lg font-semibold">
                <div class="w-4 h-4">
                    <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
                </div>
                <h1 class="text-blue-100 text-text-primary">
                    {{-- {{ ucwords(str_replace('-', ' ', $gameSlug)) . ' ' . ucwords(str_replace('-', ' ', $categorySlug)) }} --}}
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
                    {{-- <div :class="{ 'border-blue-500': selectedPayment === 'credit_card' }"
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

                    </div> --}}

                    <!-- Credit/Debit Card Form -->
                    {{-- <div x-show="selectedPayment === 'credit_card'" class="mt-6 space-y-4">
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
                    </div> --}}

                    <!-- Digital Wallet -->
                    {{-- <div :class="{ 'border-blue-500': selectedPayment === 'digital_wallet' }"
                        class="flex items-center justify-between gap-4 border border-zinc-500 rounded py-4 px-6 mt-6 cursor-pointer"
                        @click="selectedPayment = 'digital_wallet'">
                        <div class="flex items-center gap-2">
                            <div class="w-11 h-7"><img src="{{ asset('assets/images/gift_cards/google2.png') }}"
                                    class="w-full h-full"></div>
                            <div class="w-11 h-7"><img src="{{ asset('assets/images/gift_cards/apple2.png') }}"
                                    class="w-full h-full"></div>
                        </div>
                       

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
                    </div> --}}

                    {{-- Methods Comes From Method Config --}}


{{-- 
                    <!-- Digital Wallet Form -->
                    <div x-show="selectedPayment === 'digital_wallet'" class="mt-6">
                        <p class="text-text-white">{{ __('You have selected Digital Wallet payment method.') }}</p>
                    </div> --}}

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
                    <p class="text-text-white text-base font-semibold">$ {{ $order->grand_total}}</p>
                </div>
                <div class="flex justify-between mb-3">
                    <p class="text-text-white text-sm">{{ __('Payment fee') }}</p>
                    <p class="text-text-white text-base font-semibold">+0.0</p>
                </div>
                <div class="flex justify-between mb-3">
                    <p class="text-text-white text-sm">{{ __('Discount') }}</p>
                    <p class="text-text-white text-base font-semibold">+0.0</p>
                </div>
                <div class="flex justify-between mb-3">
                    <p class="text-text-white text-sm">{{ __('Cart Total') }}</p>
                    <p class="text-text-white text-base font-semibold">${{ $order->grand_total}}</p>
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


                {{-- Copied And Paste --}}

                {{-- Coppied and Past             e --}}

                 <div class="mt-8 lg:px-78 px-0">
                    <x-ui.button href="#" class="w-auto py-3!">
                       $  {{ $order->grand_total }}{{ __('| Buy now') }}
                    </x-ui.button>
                </div>
            </div>
        </div>

        <!-- Don't forget to include Alpine.js -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    </form>


    
 <div class="max-w-6xl mx-auto my-12 p-4 md:p-8 bg-white rounded-3xl shadow-2xl border border-gray-100">

        <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">
            Finalizing Order: <span class="text-primary"> #{{ $order->order_id }}</span>
        </h1>

        @if (session('error'))
            <div class="alert alert-error mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- 1. Payment Gateways (Left Column - 1/3) -->
            <div class="lg:col-span-1 space-y-4">
                <h2 class="text-2xl font-bold text-gray-700 mb-4 border-b pb-3">1. Choose Method</h2>

                <div class="flex flex-col gap-3">
                    @forelse ($gateways as $gatewayItem)
                        <label
                            class="gateway-label flex items-center p-4 rounded-xl transition-all duration-300 shadow-md border-2 cursor-pointer
                        {{ $gatewayItem->slug === $gateway ? 'border-primary ring-2 ring-primary/50 bg-base-200' : 'border-gray-200 hover:bg-base-100' }}">

                            <input type="radio" class="radio radio-primary radio-sm" value="{{ $gatewayItem->slug }}"
                                wire:model.live="gateway" name="gateway"
                                {{ $gatewayItem->slug === $gateway ? 'checked' : '' }} />

                            <span class="ml-4 text-lg font-medium text-gray-700">{{ $gatewayItem->name }}</span>
                        </label>
                    @empty
                        <div class="alert alert-warning shadow-lg rounded-xl">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span>No payment gateways are currently configured.</span>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 2. Order Summary & Payment Details (Right Column - 2/3) -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Order Summary Card -->
                <div class="card bg-gray-50 border border-gray-200 rounded-2xl shadow-inner p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-3">2. Order Summary</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between text-lg">
                            <span>Product:</span>
                            <span class="font-semibold">{{ $order->source?->name ?? 'Unknown' }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-medium pt-2 border-t border-gray-300">
                            <span>Total Due:</span>
                            <span
                                class="text-primary font-extrabold text-2xl">${{ number_format($order->grand_total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Stripe Payment Form -->
                @if ($gateway === 'stripe')
                    <div id="stripe-payment-section"
                        class="space-y-6 card p-6 bg-white border border-gray-200 rounded-2xl shadow-lg">

                        <h2 class="text-2xl font-bold text-gray-800 border-b pb-3">3. Card Details</h2>

                        <!-- Stripe Card Element Container -->
                        <div id="card-element" class="p-4 border border-gray-300 rounded-lg bg-gray-50"></div>

                        <!-- Error Messages -->
                        <div id="card-errors" class="text-error text-sm hidden"></div>

                        <!-- Pay Button -->
                        <button type="button" id="submit-payment"
                            class="btn btn-primary btn-lg w-full rounded-xl mt-6 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.005] focus:ring-4 focus:ring-primary/50">
                            <span id="button-text">Pay Now - ${{ number_format($order->grand_total, 2) }}</span>
                            <span id="button-loader" class="loading loading-spinner loading-sm hidden"></span>
                        </button>
                    </div>
                @elseif ($gateway === 'paypal')
                    <!-- PayPal Payment Section (Future) -->
                    <div class="space-y-6 card p-6 bg-white border border-gray-200 rounded-2xl shadow-lg">
                        <h2 class="text-2xl font-bold text-gray-800 border-b pb-3">3. PayPal Payment</h2>
                        <p class="text-gray-600">PayPal integration coming soon...</p>
                    </div>
                @elseif ($gateway === 'coinbase')
                    <!-- Coinbase Payment Section (Future) -->
                    <div class="space-y-6 card p-6 bg-white border border-gray-200 rounded-2xl shadow-lg">
                        <h2 class="text-2xl font-bold text-gray-800 border-b pb-3">3. Coinbase Payment</h2>
                        <p class="text-gray-600">Coinbase integration coming soon...</p>
                    </div>
                @endif

                <p class="text-center text-sm text-gray-500 mt-6">
                    All payments are processed securely. By completing this purchase, you agree to our <a href="#"
                        class="text-primary hover:underline font-medium">Terms of Service</a>.
                </p>
            </div>
        </div>
    </div>

    <!-- Stripe.js Integration -->
    @if ($gateway === 'stripe')
        @push('scripts')
            <script src="https://js.stripe.com/v3/"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    initializeStripePayment();
                });

                // Listen for Livewire updates (when gateway changes)
                document.addEventListener('livewire:navigated', function() {
                    if (document.getElementById('stripe-payment-section')) {
                        initializeStripePayment();
                    }
                });
                document.addEventListener('livewire:initialized', function() {
                    initializeStripePayment();
                });

                function initializeStripePayment() {
                    // Check if already initialized
                    if (window.stripeInitialized) {
                        return;
                    }

                    // Check if Stripe elements exist
                    const cardElementContainer = document.getElementById('card-element');
                    if (!cardElementContainer) {
                        return;
                    }

                    // Initialize Stripe
                    const stripe = Stripe('{{ config('services.stripe.key') }}');

                    // Create elements
                    const elements = stripe.elements();
                    const cardElement = elements.create('card', {
                        theme: 'flat',
                        style: {
                            base: {
                                fontSize: '16px',
                                color: '#424770',
                                '::placeholder': {
                                    color: '#aab7c4',
                                },
                            },
                            invalid: {
                                color:'#9e2146',
                            },
                            
                        },
                    });

                    // Mount card element
                    cardElement.mount('#card-element');

                    // Mark as initialized
                    window.stripeInitialized = true;

                    // Handle real-time validation errors
                    cardElement.on('change', function(event) {
                        const displayError = document.getElementById('card-errors');
                        if (event.error) {
                            displayError.textContent = event.error.message;
                            displayError.classList.remove('hidden');
                        } else {
                            displayError.textContent = '';
                            displayError.classList.add('hidden');
                        }
                    });

                    // Handle form submission
                    const submitButton = document.getElementById('submit-payment');
                    const buttonText = document.getElementById('button-text');
                    const buttonLoader = document.getElementById('button-loader');

                    submitButton.addEventListener('click', async function(event) {
                        event.preventDefault();

                        // Disable button and show loader
                        submitButton.disabled = true;
                        buttonText.classList.add('hidden');
                        buttonLoader.classList.remove('hidden');

                        try {
                            // Step 1: Initialize payment (create payment intent)
                            const initResponse = await fetch('{{ route('payment.initialize') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: JSON.stringify({
                                    order_id: '{{ $order->order_id }}',
                                    gateway: 'stripe',
                                }),
                            });

                            const initResult = await initResponse.json();

                            if (!initResult.success) {
                                throw new Error(initResult.message || 'Failed to initialize payment');
                            }

                            // Step 2: Confirm payment with Stripe.js
                            const {
                                error,
                                paymentIntent
                            } = await stripe.confirmCardPayment(
                                initResult.client_secret, {
                                    payment_method: {
                                        card: cardElement,
                                    },
                                }
                            );

                            if (error) {
                                throw new Error(error.message);
                            }

                            // Step 3: Confirm payment on backend
                            const confirmResponse = await fetch('{{ route('payment.confirm') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: JSON.stringify({
                                    payment_intent_id: paymentIntent.id,
                                    payment_method_id: paymentIntent.payment_method,
                                    gateway: 'stripe',
                                }),
                            });

                            const confirmResult = await confirmResponse.json();

                            if (confirmResult.success) {
                                // Redirect to success page
                                window.location.href = confirmResult.redirect_url;
                            } else {
                                throw new Error(confirmResult.message || 'Payment confirmation failed');
                            }

                        } catch (error) {
                            // Show error message
                            const displayError = document.getElementById('card-errors');
                            displayError.textContent = error.message;
                            displayError.classList.remove('hidden');

                            // Re-enable button
                            submitButton.disabled = false;
                            buttonText.classList.remove('hidden');
                            buttonLoader.classList.add('hidden');
                        }
                    });
                }
            </script>
        @endpush
    @endif

    <style>
        .gateway-label:focus-within {
            outline: none;
            box-shadow: 0 0 0 3px theme('colors.primary.100');
        }

        #card-element {
            min-height: 50px;
        }

        .StripeElement {
            padding: 12px;
        }

        .StripeElement--focus {
            border-color: theme('colors.primary.500');
            box-shadow: 0 0 0 3px theme('colors.primary.100');
        }

        .StripeElement--invalid {
            border-color: theme('colors.error');
        }
    </style>
</div>
