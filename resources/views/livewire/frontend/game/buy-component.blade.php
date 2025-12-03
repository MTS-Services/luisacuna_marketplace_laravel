
<section>
    <div class="max-w-7xl mx-auto px-8 py-8">
          <livewire:frontend.partials.page-inner-header :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
        <!-- Breadcrumb -->
        <a href="{{ route('game.index', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug]) }}">
            <div class="group flex items-center gap-2 my-8 text-lg font-semibold">
                <span class="text-text-primary group-hover:text-pink-400 transition-colors duration-300">
                    < </span>
                        <h1 class="text-text-white group-hover:text-pink-400 transition-colors duration-300">
                            {{ __('All Offers') }}
                        </h1>
            </div>

        </a>

        {{-- <div class="flex items-center gap-2 mb-8 text-md font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <h1 class="text-text-white">
                {{ ucwords(str_replace('-', ' ', $gameSlug)) . ' ' . ucwords(str_replace('-', ' ', $categorySlug)) }}
            </h1>

            <span class=" text-text-primary">></span>
            <span class=" text-text-primary">Buy Now</span>
        </div> --}}
        <div>

            <div class=" text-white min-h-screen">
                <div class="w-full mx-auto">
                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <!-- Left Column - Product Details -->
                        <div class="lg:col-span-2">
                            <!-- Seller Info -->
                            <div class="bg-bg-primary  rounded-lg p-6 mb-6">
                                <div class="flex items-center gap-4 mb-6">
                                    <img src="{{ asset('assets/images/Devon Lane.png') }}" alt="Devon Lane"
                                        class="w-16 h-16 rounded-full border-2 border-purple-500">
                                    <div>
                                        <h2 class="text-xl font-bold">{{__('Devon Lane')}}</h2>
                                        <div class="flex items-center gap-2 text-sm text-gray-300">
                                            <span class="text-purple-400 flex items-center ">
                                                <img class="px-2" src="{{ asset('assets/images/Subtract.png') }}"
                                                    alt="">
                                                99.3%</span>
                                            <span>{{__('2434 reviews')}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="border-t border-b border-purple-500/60 pt-4 mb-4">
                                    <div
                                        class="flex justify-between items-center py-3">
                                        <span
                                            class="text-text-primary sm:text-2xl md:text-3xl lg:text-4xl">{{ __('Delivery time') }}
                                            </span>
                                        <span
                                            class="text-gray-100 sm:text-sm md:text-md lg:text-lg">{{ __('15min') }}</span>
                                        </div>
                                </div>

                                <!-- Warning -->
                                <div class="    rounded p-4 mb-6">
                                    <p class=" sm:text-sm md:text-md lg:text-lg">{{__('READ BEFORE PURCHASE ! (ONLY
                                        GAMEPASS) 30% Tax IS NOT
                                        COVERED')}}</p>
                                </div>

                                <!-- Product Title -->
                                <h1 class="sm:text-1xl md:text-2xl lg:text-3xl mb-6">{{__('EA SPORTS FC COINS')}}</h1>

                                <!-- How to Purchase -->
                                <div class="mb-6">
                                    <h3 class=" sm:text-sm md:text-md lg:text-lg mb-3">{{__('How to purchase')}}</h3>
                                    <ol class="space-y-2 text-lg text-gray-300">
                                        <li><span class="font-semibold">1.</span>{{__('Select the amount of you want.')}}
                                        </li>
                                        <li><span class="font-semibold">2.</span>{{__('Make a gamepass and send us the
                                            link.')}}</li>
                                        <li><span class="font-semibold">3.</span>{{__('Robuxwill be Pending for 3-7
                                            days')}}</li>
                                    </ol>
                                </div>

                                <!-- Terms -->
                                <div class="space-y-4 text-lg text-gray-400">
                                    <p>{{__('(By purchasing you agree to the following terms) No refunds after
                                        purchasing a game pass
                                        We are not responsible for account bans. No refund, no after-sales
                                        service. rmt violates
                                        the game')}}</p>
                                    <p>{{__('(By purchasing you agree to the following terms) No refunds after
                                        purchasing a game pass
                                        We are not responsible for account bans. No refund, no after-sales
                                        service. rmt violates
                                        the game')}}</p>
                                </div>
                            </div>

                            <!-- Other Sellers -->
                            <div class="mt-6 ">
                                <h2 class="text-2xl font-bold mb-6">{{__('Other sellers (84)')}}</h2>
                                <div class=" rounded-full p-4 ">
                                    <button
                                        class="flex items-center justify-between  px-6 py-3 border border-purple-500/50 rounded-full hover:bg-purple-900/20 transition">
                                        <span>{{__('Recommended')}}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6 ml-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Pricing & Checkout -->
                        <div class="lg:col-span-1">
                            <!-- Price Section -->
                            <div class="bg-bg-primary rounded-lg p-6 mb-6 ">
                                <div class="mb-3 flex items-center justify-between border-b border-zinc-500">
                                    <p class="text-text-primary text-sm mb-2">{{__('Price')}}</p>
                                    <p class="text-3xl ">$76.28<span class="text-lg text-text-primary">{{__('/unit')}}</span>
                                    </p>
                                </div>
                                {{-- order incriment decriment --}}
                                <div class="p-4 rounded-lg max-w-xl mx-auto">
                                    <div class="flex items-center gap-4">
                                        <x-ui.button class="w-auto! py-1! px-3!" onclick="decreaseQuantity()">
                                            &minus;
                                        </x-ui.button>

                                        <x-ui.input type="number" id="quantity" name="quantity" class="text-center"
                                            value="300" readonly />

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
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 ">
            <!-- Card 1 -->
            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'itemSlug' => 'test']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class=" flex items-center justify-between ">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>

            <!-- Card 2 -->
            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'itemSlug' => 'test']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class="  flex items-center justify-between">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>

            <!-- Card 3 -->
            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'itemSlug' => 'test']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class=" flex items-center justify-between ">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>

            <!-- Card 4 -->
            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'itemSlug' => 'test']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class=" flex items-center justify-between ">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>

            <!-- Card 5 -->
            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'itemSlug' => 'test']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class=" flex items-center justify-between ">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>

            <!-- Card 6 -->
            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'itemSlug' => 'test']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class=" flex items-center justify-between ">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>


        </div>
        <div class="flex justify-end items-center space-x-3  p-4 m-10">
            <button class="text-text-primary text-sm hover:text-purple-500">{{__('Previous')}}</button>

            <button class="bg-purple-600 text-white text-sm px-3 py-1 rounded">1</button>
            <button class="text-text-primary text-sm hover:text-purple-500">2</button>
            <button class="text-text-primary text-sm hover:text-purple-500">3</button>
            <button class="text-text-primary text-sm hover:text-purple-500">4</button>
            <button class="text-text-primary text-sm hover:text-purple-500">5</button>

            <button class="text-text-primary text-sm hover:text-purple-500">{{__('Next')}}</button>
        </div>
    </div>

    @push('scripts')
        <script>
            function decreaseQuantity() {
                const input = document.getElementById('quantity');
                let value = parseInt(input.value);
                if (value > 1) {
                    input.value = value - 1;
                }
            }

            function increaseQuantity() {
                const input = document.getElementById('quantity');
                let value = parseInt(input.value);
                input.value = value + 1;
            }
        </script>
    @endpush
</section>
