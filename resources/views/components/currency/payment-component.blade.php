<div class="lg:col-span-1">
    <!-- Price Section -->
    <div class="bg-bg-primary rounded-lg p-6 mb-6 ">
        <div class="mb-3 flex items-center justify-between border-b border-zinc-500">
            <p class="text-text-primary text-sm mb-2">{{__('Price')}}</p>
            <p class="text-3xl ">{{ $product->price}}<span class="text-lg text-text-primary">{{__('/unit')}}</span>
            </p>
        </div>
        {{-- order incriment decriment --}}
        <div class="p-4 rounded-lg max-w-xl mx-auto">
            <div class="flex items-center gap-4">
                <x-ui.button class="w-auto! py-1! px-3!" onclick="decreaseQuantity()">
                    &minus;
                </x-ui.button>

                <x-ui.input type="number" id="quantity" name="quantity" class="text-center"
                    value="1" readonly />

                <x-ui.button class="w-auto! py-1! px-3!" onclick="increaseQuantity()">
                    +
                </x-ui.button>
            </div>

            <div class="flex justify-between mt-3 text-xs text-gray-400">
                <span>{{__('Minimum Quantity: 1000 unit')}}</span>
                <span>{{__('In Stock: 57000 unit')}}</span>
            </div>
        </div>
        <!-- Buy Button -->
        <a href="{{ route('game.checkout', ['orderId' => 12345]) }}" wire:navigate
            class="block text-center w-full bg-gradient-to-r bg-[#853EFF]  text-gray-100 sm:text-sm md:text-md lg:text-lg py-3 px-4 rounded-full mb-6 transition transform hover:scale-105">
            {{__(' $76.28 | Buy now')}}
        </a>

        <!-- Guarantees -->
        <div class="space-y-4">
            <!-- Money-back -->
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="font-semibold text-sm">{{__('Money-back Guarantee')}}</p>
                    <p class="text-xs text-gray-400">{{__('Protected by TradeShield')}}</p>
                </div>
            </div>

            <!-- Fast Checkout -->
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
                    </path>
                </svg>
                <div class="flex">
                    <p class="font-semibold text-sm">{{__('Fast Checkout Options')}}</p>
                    <div class="flex gap-0 ">
                        <span class="text-xs   px-2 rounded">
                            <img src="{{ asset('assets/images/GooglePay-Light 1.svg') }}"
                                alt="">
                        </span>
                        <span class="text-xs   px-2  rounded"> <img
                                src="{{ asset('assets/images/ApplePay-Light 1.svg') }}"
                                alt="">
                        </span>
                    </div>
                </div>
            </div>

            <!-- Support -->
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                    </path>
                </svg>
                <div>
                    <p class="font-semibold text-sm">{{__('24/7 Live Support')}}</p>
                    <p class="text-xs text-gray-400">{{__('We\'re always here to help')}}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Delivery Instructions -->
    <div class="bg-bg-primary rounded-lg  mb-6 px-4 py-4 ">
        <h3 class="font-bold mb-4">{{__('Delivery Instructions')}}</h3>
        <div class="flex gap-4 mb-4">
            <button class="text-sm text-purple-400 hover:text-purple-300">{{__('Welcome')}}</button>
            <button class="text-sm text-gray-400 hover:text-gray-300">{{__('Why choose
                                        us')}}</button>
        </div>
        <ol class="space-y-2 text-sm text-gray-300">
            <li><span class="font-semibold">1.</span> {{__('V-BUCKS are safe to hold and
                                        guaranteed!')}}</li>
            <li><span class="font-semibold">2.</span> {{__('Fast replies and delivery.')}}</li>
        </ol>
        <button
            class="text-purple-400 hover:text-purple-300 text-sm mt-4 mb-4 font-semibold">{{__('See
                                    all')}}</button>
        <!-- Seller Card -->
        <div class="bg-bg-primary  p-4 border-t border-purple-800 ">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/images/Soham (2).png') }}" alt="Soham"
                    class="w-12 h-12 rounded-full border-2 border-purple-500">
                <div class="flex-1">
                    <p class="font-bold">{{__('Soham')}}</p>
                    <div class="flex items-center gap-2 text-xs text-gray-400">
                        <span class="text-purple-400">99.3%</span>
                        <span>2434 reviews</span>
                        <span>1642 Sold</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>