<section class="mx-auto bg-bg-primary">
    <div class="container mx-auto">
        {{-- breadcrumb --}}
        <div class="flex gap-4 items-center py-10">
            <x-phosphor name="less-than" variant="regular" class="w-4 h-4 text-zinc-400" />
            <h2 class="text-text-white text-base">
                {{ __('All Orders') }}

            </h2>
        </div>
        <div class="flex justify-between">
            <div class="flex gap-5">
                <div>
                    <div class="w-10 h-10 md:w-16 md:h-16">
                        <img src="{{ asset('assets/images/order/order.png') }}" alt="Product Name"
                            class="w-full h-full rounded-lg">
                    </div>
                </div>
                <div>
                    <h2 class="text-text-white text-2xl font-semibold line-clamp-1">
                        {{ __('Mercury Spark — Ultimate 5-Star Boost') }}
                    </h2>
                    <p class="text-text-white font-normal text-base line-clamp-1">
                        {{ __('Order ID: 98bc4674-4bde-4498-9175-a4a0318458e0') }}</p>
                </div>
            </div>
            <div class="">
                <x-ui.button class="bg-pink-700! w-fit! py-2! px-4! sm:py-3! sm:px-6! border-none!">
                    {{ __('Canceled') }}
                </x-ui.button>
            </div>
        </div>
        <div class="block lg:flex gap-6 justify-between items-start mt-10 mb-20">
            <div class="w-full lg:w-2/3">
                <div class=" bg-bg-secondary p-4 sm:p-10 rounded-lg">
                    <div class="flex gap-4 items-center">
                        <div class="bg-bg-info rounded-full p-3">
                            <x-phosphor name="info" variant="regular" class="w-6 h-6 text-zinc-400" />
                        </div>
                        <h3 class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Order cancelled') }}</h3>
                    </div>
                    <div class="">
                        <div class="mt-7">
                            <p class="text-text-white text-base mb-2">{{ __('Dispute reason:') }}</p>
                            <p class="text-text-white text-base sm:text-2xl font-semibold">
                                {{ __('I have another issue') }}</p>
                        </div>
                        <div class="mt-5">
                            <p class="text-text-white text-base mb-2">{{ __('Cancelled by:') }}</p>
                            <p class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Seller') }}</p>
                        </div>
                        <div class="mt-5">
                            <p class="text-text-white text-base mb-2">{{ __('Cancelation reason:') }}</p>
                            <p class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Others') }}</p>
                        </div>
                        <div class="mt-5">
                            <p class="text-text-white text-base mb-2">{{ __('Comment:') }}</p>
                            <p class="text-text-white text-base sm:text-2xl font-semibold">
                                {{ __('buyer requested to cancel the order') }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10">
                    <!-- Bullet Points -->
                    <ul class="list-disc list-inside text-text-white text-xl">
                        <li class="text-text-white text-base sm:text-xl font-normal mb-3">
                            {{ __('You received a refund for this order in your') }}
                            <span class="text-pink-500">{{ __('"Company name"') }}</span
                                class="text-text-white text-xl font-normal"> {{ __('balance') }}
                        </li>
                        <li class="text-text-white text-base sm:text-xl font-normal mb-3">
                            {{ __('When you place a new order, your balance will be used automatically') }}
                        </li>
                        <li class="text-text-white text-base sm:text-xl font-normal mb-3">
                            {{ __('You will not be charged payment fees again') }}</li>
                    </ul>

                    <!-- Button -->
                    <div class="flex w-full md:w-auto mt-10!">
                        <x-ui.button href="{{ route('user.OngoingOrder.details') }}" class="w-fit! py-3! px-6!">
                            {{ __('Buy again') }}
                            <x-phosphor-arrow-right-light
                                class="w-5 h-5 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" /></x-ui.button>
                    </div>
                    {{-- <!-- Note -->
                    <p class="mt-4 text-xs text-text-white">
                        <span class="text-text-white text-base  font-semibold">{{ __('Note: ') }}</span>
                        {{ __('Spend your') }} <span class="text-pink-500">{{ __('"Company name"') }}</span>
                        {{ __('balance') }}
                    </p> --}}
                    <div class="w-fit bg-bg-info rounded-lg mt-20 px-4 py-2 flex items-center gap-3">
                        <x-phosphor name="info" variant="regular" class="w-6 h-6 text-zinc-400" />
                        <p class="text-text-white text-xs font-normal">
                            {{ __('Please DO NOT deliver order to buyer. The payment was returned back to the buyer.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/3">
                <div class="bg-bg-secondary p-4 sm:p-7 mt-10 lg:mt-0 rounded-lg">
                    <div class="flex gap-4 items-center">
                        <h3 class="text-text-white text-2xl font-semibold">{{ __('Order cancelled') }}</h3>
                    </div>
                    <div class="">
                        <div class="flex justify-between mt-7">
                            <p class="text-text-white text-base font-semibold mb-2">{{ __('Game') }}</p>
                            <div class="flex gap-2 items-center">
                                <div>
                                    <div class="w-6 h-6">
                                        <img src="{{ asset('assets/images/order.png') }}" alt="Product Name"
                                            class="w-full h-full object-cover">
                                    </div>
                                </div>
                                <p class="text-text-white text-base font-normal">{{ __('Fortnite') }}</p>
                            </div>
                        </div>
                        <div class="flex justify-between mt-2">
                            <p class="text-text-white text-base font-semibold mb-2">{{ __('Username') }}</p>
                            <p class="text-text-white text-base font-normal">{{ __('acuzone') }}</p>
                        </div>
                        <div class="flex justify-between mt-2">
                            <p class="text-text-white text-base font-semibold mb-2">{{ __('Device') }}</p>
                            <p class="text-text-white text-base font-normal">{{ __('PC') }}</p>
                        </div>
                        <div class="flex justify-between mt-2">
                            <p class="text-text-white text-base font-semibold mb-2">{{ __('Seller') }}</p>
                            <p class="flex items-center gap-2 text-base font-normal">
                                <span class="text-pink-500">{{ __('DI 8QUAN') }}</span>
                                <span class="text-text-white">|</span>
                                <span class="w-2.5 h-2.5 bg-green-500 rounded-full"></span>
                                <span class="text-text-white">{{ __('Online') }}</span>
                            </p>
                        </div>
                        <div class="flex justify-between mt-2">
                            <p class="text-text-white text-base font-semibold mb-2">{{ __('Total price') }}</p>
                            <p class="text-text-white text-base font-normal">{{ __('$1.20') }}</p>
                        </div>
                    </div>
                    <div class="flex w-full md:w-auto justify-center items-center mt-10!">
                        <a href="{{ route('user.order-description') }}">
                            <x-ui.button class="w-fit! py-3! px-6!">
                                {{ __('View full description') }}
                                <x-phosphor-arrow-right-light
                                    class="w-5 h-5 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" /></x-ui.button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-bg-info rounded-lg">
            <!-- User Header -->
            <div class="hidden md:flex items-center justify-between bg-zinc-500 rounded-tl-lg rounded-tr-lg p-5">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/order/seller.png') }}" alt="User"
                        class="w-10 h-10 rounded-full">
                    <div>
                        <h3 class="text-text-white text-2xl font-semibold">{{ __('D18QUANB') }}</h3>
                        <p class="text-text-white text-base font-normal">{{ __('Order for Items') }}</p>
                    </div>
                </div>
                <div class="relative flex items-center ml-auto">
                    <flux:icon name="magnifying-glass"
                        class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 stroke-text-primary pointer-events-none z-10" />
                    <input type="text" wire:model.live="search" placeholder="Search conversion"
                        class="border dark:border-white border-gray-600 rounded-full py-2 pl-8 pr-2 text-sm focus:border-zinc-500 focus:bg-zinc-500 w-full bg-transparent placeholder:text-text-primary">
                </div>
            </div>
            <div class="mt-12 p-4 sm:p-20">
                <!-- User Header -->
                <div
                    class="flex items-center justify-between bg-bg-secondary rounded-lg p-5 border-l-4 border-pink-500 mb-10">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('assets/images/order/seller.png') }}" alt="User"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <h3 class="text-text-white text-2xl font-semibold">{{ __('D18QUANB') }}</h3>
                            <p class="text-text-white text-base font-normal">{{ __('Order for Items') }}</p>
                        </div>
                    </div>
                    {{-- <div class="relative flex items-center ml-auto">
                        <flux:icon name="magnifying-glass"
                            class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 stroke-text-primary pointer-events-none z-10" />
                        <input type="text" wire:model.live="search" placeholder="Search conversion"
                            class="border dark:border-white border-gray-600 rounded-full py-2 pl-8 pr-2 text-sm focus:outline-none focus:border-zinc-500 focus:bg-bg-primary w-full bg-transparent placeholder:text-text-primary">
                    </div> --}}
                </div>

                <!-- Order Created Message -->
                <div class="bg-bg-secondary rounded-lg p-5 border-l-4 border-pink-500 mb-10">
                    <div>
                        <p class="text-text-white text-base mb-2 break-all">
                            {{ __('Order Created:') }}
                            <a href="#" class="text-accent">
                                https://www.companyname.ga/order/d8bcd674-dbde-4d98-9175-a4a031845de0
                            </a>
                        </p>

                        <div class="bg-bg-info rounded-lg mt-4 px-6 py-3">
                            <div class="flex items-center gap-2 text-primary-400 text-sm mb-1">
                                <x-phosphor name="link" variant="" class="fill-zinc-500" />

                                <span class="text-text-white">d8bcd674-dbde-4d98-9175-a4a031U58e0</span>
                            </div>
                            <a class="text-text-white text-xs" href="#">www.companyname.com</a>
                        </div>
                    </div>
                    <p class="text-text-white text-xs text-right mt-3">Oct 20 2025</p>
                </div>

                <!-- Order Disputed -->
                <div class="bg-bg-secondary rounded-lg p-5 border-l-4 border-pink-500 mb-10">
                    <div class="bg-bg-info rounded-lg mt-4 px-6 py-3">
                        <p class="text-text-white text-base mb-2">{{ __('Order Disputed by Buyer:') }}</p>
                        <div class="flex items-center gap-2 text-primary-400 text-sm mb-1">
                            <span class="text-text-white">{{ __('Reason: I don\'t want it anymore') }}</span>
                        </div>
                    </div>
                    <p class="text-text-white text-xs text-right mt-3">Oct 20 2025</p>
                </div>

                <!-- Buyer Message -->
                <div>
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('assets/images/order/seller.png') }}" alt="User"
                            class="w-10 h-10 rounded-full">
                        <div class="flex-1">
                            <div class="bg-primary-800 rounded-lg">
                                <x:input type="text" placeholder="Hi, what's the problem?" class="w-full" />
                            </div>

                        </div>
                    </div>
                    <p class="text-text-white text-right text-xs mt-1">Oct 20 2025</p>
                </div>

                <!-- Seller Message -->
                <div class="mt-10">
                    <div class="flex items-center gap-3">
                        <div class="flex-1">
                            <div class="bg-primary-800 rounded-lg">
                                <p class="bg-zinc-500 px-6 py-3 text-right rounded-lg">
                                    {{ __('Please cancel the order, I don\'t want it anymore.') }}</p>
                            </div>

                        </div>
                        <img src="{{ asset('assets/images/order/seller.png') }}" alt="User"
                            class="w-10 h-10 rounded-full">
                    </div>
                    <p class="text-text-white text-left text-xs mt-1">Oct 20 2025</p>
                </div>

                <!-- Buyer Response -->
                <div>
                    <div class="flex items-center gap-3 mt-10">
                        <img src="{{ asset('assets/images/order/seller.png') }}" alt="User"
                            class="w-10 h-10 rounded-full">
                        <div class="flex-1">
                            <div class="bg-primary-800 rounded-lg">
                                <x:input type="text" placeholder="Okay" class="w-full" />
                            </div>

                        </div>
                    </div>
                    <p class="text-text-white text-right text-xs mt-1">Oct 20 2025</p>
                </div>

                <!-- Dispute Won -->
                <div class="bg-bg-secondary rounded-lg p-5 border-l-4 border-pink-500 mt-10">
                    <div class="bg-bg-info rounded-lg mt-4 px-6 py-3">
                        <p class="text-text-white text-base mb-2">{{ __('Order Disputed by Buyer:') }}</p>
                        <div class="flex items-center gap-2 text-primary-400 text-sm mb-1">
                            <span class="text-text-white">{{ __('Reason: I don\'t want it anymore') }}</span>
                        </div>
                    </div>
                    <p class="text-text-white text-xs text-right mt-3">Oct 30 2025</p>
                </div>

                <!-- Conversation Closed -->
                <div class="bg-primary-800 rounded-lg mt-10">
                    <p class="bg-zinc-500 px-6 py-3 rounded-lg">
                        {{ __('this conversation is no longer active.') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-bg-info rounded-lg mt-20 mb-24! !py-8 !px-4 md:!py-20 md:!px-10">
            <div class="flex items-center gap-3">
                <div class="w-16 h-16">
                    <img src="{{ asset('assets/images/order/Security.png') }}" alt="Security tips"
                        class="w-full h-full rounded-lg">
                </div>
                <div class="">
                    <h2 class="text-text-white text-3xl font-semibold">{{ __('Security tips') }}</h2>
                </div>
            </div>
            <div class="mt-8">
                <p class="text-text-white">
                    {{ __('For your protection, you must always pay and communicate directly through the Eldorado website. If you stay on Eldorado throughout the entire transaction—from payment, to communication, to delivery—you are protected by Tradeshield. Additionally, be aware that sellers will never ask for your currency or items back after the order is delivered, so you should not respond to any messages requesting this.') }}
                </p>
            </div>
        </div>
    </div>
    <div class="pb-10 sm:pb-20 md:pb-32"></div>
</section>
