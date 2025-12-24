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
                    {{ __('Cancel') }}
                </x-ui.button>
            </div>
        </div>
        <div class="block lg:flex gap-6 justify-between items-start mt-10 mb-20">
            <div class="w-full lg:w-2/3">
                <div class=" bg-bg-secondary p-4 sm:p-10 rounded-[20px]">
                    <div class="flex gap-4 items-center">
                        <div class="bg-bg-info rounded-full p-3">
                            <x-phosphor name="check" variant="regular" class="w-9 h-9 text-zinc-400" />
                        </div>
                        <div>
                            <h3 class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Order Active') }}
                            </h3>
                            <p class="text-text-white text-xs font-normal mt-2">{{ _('Jun 11, 2024, 1:22:12 AM') }}</p>
                        </div>
                    </div>
                    <div class="mt-7">
                        <p class="text-text-white text-base font-normal mb-2">
                            {{ __('Order is marked as completed. Funds will be added to your Eldorado balance.') }}</p>
                    </div>
                </div>

                <div class=" bg-bg-secondary p-4 sm:p-10 rounded-[20px] mt-6">
                    <div class="flex gap-4 items-center">
                        <div>
                            <h3 class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Buyer feedback') }}
                            </h3>
                        </div>
                    </div>
                    <div class="bg-bg-info flex items-center gap-2 rounded-lg py-3 px-6 mt-7">
                        <x-phosphor name="thumbs-up" variant="solid" class="w-5 h-5 fill-zinc-700" />
                        <p class="text-text-white text-base font-normal">
                            {{ __('GGWP!') }}</p>
                    </div>
                </div>

                <div class="bg-bg-info rounded-lg mt-20">
                    <!-- User Header -->
                    <div
                        class="hidden md:flex items-center justify-between bg-zinc-500 rounded-tl-lg rounded-tr-lg p-5">
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
                                <p class="text-text-white text-base mb-2">
                                    {{ __('Order Delivered. If you received goods or services, please mark this Order as "Received" and leave feedback. If you were happy with your buying experience, consider leaving a Trustpilot review, we greatly appreciate it!') }}
                                </p>
                                <div class="flex items-center gap-2 text-primary-400 text-sm mb-1">
                                    <a href="#"
                                        class="text-text-white text-xs">{{ __('www.companyname.com') }}</a>
                                </div>
                            </div>
                            <p class="text-text-white text-xs text-right mt-3">Oct 30 2025</p>
                        </div>


                        <div class="flex items-end gap-2 sm:gap-3 mt-10">
                            <div class="flex-1 relative">
                                <textarea wire:model="message" wire:keydown.enter.prevent="sendMessage" rows="1"
                                    placeholder="Say something....."
                                    class="w-full bg-bg-info text-text-white px-3 sm:px-4 py-2 sm:py-3 pr-12 sm:pr-14 rounded-lg     focus:outline-none focus:ring-2 focus:ring-accent resize-none text-xs sm:text-sm"
                                    style="min-height: 40px; max-height: 120px;"></textarea>
                                <div
                                    class="absolute right-2 sm:right-3 bottom-3 sm:bottom-4 flex items-center gap-1 sm:gap-2">
                                    <label
                                        class="cursor-pointer text-text-muted hover:text-text-primary transition-colors">
                                        <input type="file" wire:model="media" class="hidden" accept="image/*"
                                            multiple>
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                            </path>
                                        </svg>
                                    </label>
                                    <button wire:click="sendMessage"
                                        class="text-text-muted hover:text-text-primary transition-colors">
                                        <x-phosphor name="paper-plane-tilt" variant="" class="" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-1/3">
                <div class="bg-bg-secondary rounded-[20px] p-7 mb-6 mt-6 md:mt-0">
                    <p class="text-2xl font-semibold mb-6">{{ __('Delivery time') }}</p>

                    <div class="flex items-center justify-between text-center">
                        <!-- Hours -->
                        <div class="flex-1">
                            <p class="text-3xl text-text-white font-semibold">7</p>
                            <p class="text-xl text-text-white font-normal mt-1">{{ __('Hours') }}</p>
                        </div>

                        <!-- Divider -->
                        <div class="w-px h-16 bg-zinc-700"></div>

                        <!-- Minutes -->
                        <div class="flex-1">
                            <p class="text-3xl font-semibold">59</p>
                            <p class="text-xl text-text-white font-normal mt-1">{{ __('Minutes') }}</p>
                        </div>

                        <!-- Divider -->
                        <div class="w-px h-16 bg-zinc-700"></div>

                        <!-- Seconds -->
                        <div class="flex-1">
                            <p class="text-3xl font-semibold">52</p>
                            <p class="text-xl text-text-white font-normal mt-1">{{ __('Seconds') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-bg-secondary p-4 sm:p-7 mt-10 lg:mt-0 rounded-[20px]">
                    <div class="flex gap-4 items-center">
                        <h3 class="text-text-white text-2xl font-semibold">{{ __('Order Details') }}</h3>
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
                            {{-- <p class="text-text-white text-base font-normal">{{ __('DI 8QUAN Online') }}</p> --}}
                            <p class="flex items-center gap-2 text-base font-normal">
                                <span class="text-pink-500">{{ __('DI 8QUAN') }}</span>
                                <span class="text-text-white">|</span>
                                <span class="w-2.5 h-2.5 bg-green-500 rounded-full"></span>
                                <span class="text-text-white">{{ __('Online') }}</span>
                            </p>

                        </div>
                    </div>
                    <div class="flex w-full md:w-auto justify-center items-center mt-10!">
                        <a href="{{ route('user.order.detail', ['orderId' => $order->id]) }}">
                            <x-ui.button class="w-fit! py-3! px-6!">
                                {{ __('View full description') }}
                                <x-phosphor-arrow-right-light
                                    class="w-5 h-5 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" /></x-ui.button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-10 sm:pb-20 md:pb-32"></div>
</section>
