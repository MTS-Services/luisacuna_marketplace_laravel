<div class="bg-bg-primary">
    <div class="container">
        <div class="flex gap-4 items-center pt-10">
            <x-phosphor name="less-than" variant="regular" class="w-4 h-4 text-zinc-400" />
            <h2 class="text-text-white text-base">
                {{ __('Back') }}
            </h2>
        </div>
        <div class="bg-bg-secondary p-4 sm:p-10 md:p-20 rounded-lg mt-10 md:mt-44">
            <div class="flex mt-7">
                <div class="flex gap-2">
                    <div>
                        <div class="w-10 h-10 sm:w-12 sm:h-12">
                            <img src="{{ asset('assets/images/order.png') }}" alt="Product Name"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                    <p class="text-text-white text-3xl font-semibold">{{ __('Fortnite') }}</p>
                </div>
            </div>
            <div class="bg-bg-info p-7 rounded-lg mt-10">
                <div class="flex gap-5">
                    <div>
                        <div class="w-10 h-10">
                            <img src="{{ asset('assets/images/order/order.png') }}" alt="Product Name"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div>
                        <h2 class="text-text-white text-base sm:text-2xl font-semibold line-clamp-1">
                            {{ __('Mercury Spark — Ultimate 5-Star Boost') }}
                        </h2>
                    </div>
                </div>
                <div class="mt-6">
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Username') }}</p>
                        <p class="text-text-white text-base font-normal">{{ __('acuzone') }}</p>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Device') }}</p>
                        <p class="text-text-white text-base font-normal">{{ __('PC') }}</p>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Quantity') }}</p>
                        <p class="text-text-white text-base font-normal">{{ __('6') }}</p>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Guaranteed delivery time') }}
                        </p>
                        <p class="text-text-white text-base font-normal">{{ __('1 Days') }}</p>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Delivery method') }}</p>
                        <p class="text-text-white text-base font-normal">{{ __('In-game delivery') }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <div class="w-auto h-auto sm:w-[400px] sm:h-[400px]">
                    <img src="{{ asset('assets/images/order/Mercury_LMG_-_Schematic_-_Save_the_World 1.png') }}"
                        alt="Product Name" class="w-full h-full object-cover">
                </div>
                <div class="mt-6">
                    <h3 class="text-text-white text-2xl font-semibold">{{ __('Description') }}</h3>
                    <p class="mt-2 text-text-white text-xl font-normal">
                        {{ __('Mercury Spark — Ultimate 5-Star Boost') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-bg-info px-4 sm:px-10 md:px-20 py-4 sm:py-10 rounded-2xl mt-10">
            <h2 class="text-text-white text-2xl font-semibold">{{ __('Seller') }}</h2>
            <div class="mt-3">
                <div class="pt-4 mt-4 flex items-center gap-5">
                    <div class="w-14 h-14">
                        <img src="{{ asset('assets/images/order/seller.png') }}" alt="Esther"
                            class="w-full h-full rounded-full">
                    </div>
                    <div>
                        <p class="font-semibold ">{{ __('Soham') }}</p>
                        <p class="text-sm text-text-white "> <img class="inline mr-2"
                                src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                            {{ __('99.3% | 2434 reviews | 1642 Sold') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-bg-info px-4 sm:px-10 md:px-20 py-4 sm:py-10 rounded-2xl mt-10 mb-10 sm:mb-32">
            <h2 class="text-text-white text-2xl font-semibold">{{ __('Payment') }}</h2>
            <div class="flex justify-between mt-3">
                <p class="text-text-white text-base font-semibold mb-2">{{ __('Total price') }}</p>
                <p class="text-text-white text-base font-normal">{{ __('$1.20') }}</p>
            </div>
            <div class="flex justify-between mt-2">
                <p class="text-text-white text-base font-semibold mb-2">{{ __('Payment fee') }}</p>
                <p class="text-text-white text-base font-normal">{{ __('$0.00') }}</p>
            </div>
            <div class="flex justify-between mt-2">
                <p class="text-text-white text-base font-semibold mb-2">{{ __('Quantity') }}</p>
                <p class="text-text-white text-base font-normal">{{ __('6') }}</p>
            </div>
            <div class="flex justify-between mt-2">
                <p class="text-text-white text-base font-semibold mb-2">{{ __('Guaranteed delivery time') }}
                </p>
                <p class="text-text-white text-base font-normal">{{ __('1 Days') }}</p>
            </div>
            <div class="flex justify-between mt-2">
                <p class="text-text-white text-base font-semibold mb-2">{{ __('“Company” balance') }}</p>
                <p class="text-text-white text-base font-normal">{{ __('$1.20') }}</p>
            </div>
            <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
            <div class="flex justify-between mt-2">
                <p class="text-text-white text-2xl font-semibold mb-2">{{ __('Total:') }}</p>
                <p class="text-text-white text-base font-normal">{{ __('$0.00') }}</p>
            </div>
        </div>
    </div>
    <div class="pb-10 sm:pb-20 md:pb-32"></div>
</div>
