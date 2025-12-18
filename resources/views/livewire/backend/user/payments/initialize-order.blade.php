<div class="lg:col-span-1 ">

    <form x-data="{
        quantity: @entangle('quantity').live,
        price: {{ $product->price }},
        stock: {{ $product->quantity }}
    }" wire:submit="submit">
        <div class="bg-bg-secondary rounded-lg p-6 mb-6 ">
            <div class="pt-4 mb-8">
                <div class="flex justify-between items-center ">
                    <span class="text-text-primary text-base">{{ __('Delivery time') }}
                    </span>
                    <span class="text-gray-100 sm:text-sm bg-pink-500  px-3 py-1 rounded-full">
                        {{ $product->delivery_timeline }}
                    </span>
                </div>
            </div>

            <div class="pt-4 mb-6">
                <div class="flex justify-between items-center ">
                    <p class="text-text-primary text-xl">{{ $product->name }}
                    </p>
                </div>
            </div>

            {{-- order incriment decriment --}}
            <div class="py-4 rounded-lg max-w-xl mx-auto">
                <div class="flex items-center justify-between gap-2">
                    <x-ui.button class="w-auto! py-1! px-3! rounded!"
                        x-on:click.prevent="quantity = Math.max(1, quantity - 1)">
                        <flux:icon name="minus"
                            class="w-5 h-5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    </x-ui.button>

                    <x-ui.input type="number" x-model.number="quantity" min="1" :max="$product->quantity"
                        class="text-center w-22 py-1! px-3! border-zinc-500" />

                    <x-ui.button class="w-auto! py-1! px-3! rounded!"
                        x-on:click.prevent="quantity = Math.min(stock, quantity + 1)">
                        <flux:icon name="plus"
                            class="w-5 h-5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    </x-ui.button>
                </div>

                <div>
                    @foreach ($product->product_configs as $config)
                        @if (!$config->game_configs->field_name)
                            @continue
                        @endif
                        <div class="flex justify-between mt-3 text-xs text-gray-400">
                            <span>{{ $config->game_configs->field_name }}</span>
                            <span>{{ $config->value }}</span>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>





        <!-- Delivery Instructions -->
        <div class="bg-bg-secondary rounded-lg  mb-6 px-4 py-4 ">

            <div class="pt-4 mb-8">
                <div class="flex justify-between items-center border-b border-zinc-500/60 pb-4">
                    <span class="text-text-primary text-base">{{ __('Price') }}
                    </span>
                    <span class="text-gray-100 sm:text-sm px-3 py-1 ">
                        <span>PEN </span>
                        <span x-text="(quantity * price).toFixed(2)"
                            class="text-text-btn-primary group-hover:text-text-btn-secondary"></span>
                    </span>
                </div>
            </div>
            <!-- Buy Button -->
            @auth('web')
                <x-ui.button class="w-full mb-6 py-2!" type="submit">
                    PEN <span x-text="(quantity * price).toFixed(2)"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary "></span>
                    {{ __('Buy Now') }}
                </x-ui.button>
            @else
                <a href="{{ route('login') }}" wire:navigate
                    class="bg-zinc-500 px-4 md:px-6 py-2! md:py-2! text-text-btn-primary hover:text-text-btn-secondary hover:bg-zinc-50 border border-zinc-500 focus:outline-none focus:ring focus:ring-pink-500 font-medium text-base w-full rounded-full flex items-center justify-center gap-2 disabled:opacity-50 transition duration-150 ease-in-out group text-nowrap cursor-pointer w-full mb-6">
                    PEN <span x-text="(quantity * price).toFixed(2)"
                        class=" text-text-btn-primary group-hover:text-text-btn-secondary"></span>
                    {{ __('Buy Now') }}
                </a>
            @endauth
            <!-- Guarantees -->
            <div class="space-y-4">
                <!-- Money-back -->
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="font-semibold text-sm">{{ __('Money-back Guarantee') }}</p>
                        <p class="text-xs text-gray-400">{{ __('Protected by TradeShield') }}</p>
                    </div>
                </div>

                <!-- Fast Checkout -->
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
                        </path>
                    </svg>
                    <div class="flex">
                        <p class="font-semibold text-sm">{{ __('Fast Checkout Options') }}</p>
                        <div class="flex gap-0 ">
                            <span class="text-xs   px-2 rounded">
                                <img src="{{ asset('assets/images/GooglePay-Light 1.svg') }}" alt="">
                            </span>
                            <span class="text-xs   px-2  rounded"> <img
                                    src="{{ asset('assets/images/ApplePay-Light 1.svg') }}" alt="">
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Support -->
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                        </path>
                    </svg>
                    <div>
                        <p class="font-semibold text-sm">{{ __('24/7 Live Support') }}</p>
                        <p class="text-xs text-gray-400">{{ __('We\'re always here to help') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delivery Instructions -->
        <div class="bg-bg-secondary rounded-lg  mb-6 px-4 py-4 ">
            <h3 class="font-bold mb-4">{{ __('Delivery Instructions') }}</h3>
            <div class="flex gap-4 mb-4">
                <button class="text-sm text-purple-400 hover:text-purple-300">{{ __('Welcome') }}</button>
                <button class="text-sm text-gray-400 hover:text-gray-300">{{ __('Why choose us') }}</button>
            </div>
            <ol class="space-y-2 text-sm text-gray-300">
                <li><span class="font-semibold">1.</span>
                    {{ __('V-BUCKS are safe to hold and guaranteed!') }}
                </li>
                <li><span class="font-semibold">2.</span> {{ __('Fast replies and delivery.') }}</li>
            </ol>
            <button
                class="text-purple-400 hover:text-purple-300 text-sm mt-4 mb-4 font-semibold">{{ __('See ll') }}</button>
            <!-- Seller Card -->
            <div class="bg-bg-primary  p-4 border-t border-purple-800 ">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/Soham (2).png') }}" alt="Soham"
                        class="w-12 h-12 rounded-full border-2 border-purple-500">
                    <div class="flex-1">
                        <p class="font-bold">{{ __('Soham') }}</p>
                        <div class="flex items-center gap-2 text-xs text-gray-400">
                            <span class="text-purple-400">99.3%</span>
                            <span>2434 reviews</span>
                            <span>1642 Sold</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>

</div>
