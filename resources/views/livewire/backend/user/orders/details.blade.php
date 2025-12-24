<div class="bg-bg-primary">
    <div class="container">
        <div class="flex gap-4 items-center pt-10">
            <x-phosphor name="less-than" variant="regular" class="w-4 h-4 text-zinc-400" />
            <h2 class="text-text-white text-base">
                {{ __('Back') }}
            </h2>
        </div>
        <div class="bg-bg-secondary p-4 sm:p-10 md:p-20 rounded-lg mt-10">
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
            </div>
            <div x-data="{ isExpanded: false }" class="mt-10">
                <h1 class="text-text-white text-2xl font-bold mb-6">{{ __('Description') }}</h1>

                <div class="mb-6">
                    <p class="text-text-white text-xl font-normal mb-2">
                        {{ __(' 🔴 IMPORTANT — PLEASE READ BEFORE ORDERING TO AVOID CANCELLATION OR REFUND! 🔴') }}
                    </p>
                    <p class="text-text-white text-xl font-normal mb-4">{{ __('🔴 FRIENDSHIP REQUIRED: 🔴') }}</p>
                    <p class="text-text-white text-xl font-normal mb-2">
                        {{ __('To follow Epic Games gifting policy, we must be Epic friends for at least 48 hours before sending gifts.') }}
                    </p>
                    <p class="text-text-white text-xl font-normal mb-2">
                        {{ __('Please send friend requests to all of these accounts:') }}</p>
                </div>

                <!-- Read More Button -->
                <div x-show="!isExpanded" class="flex w-fit!">
                    <x-ui.button @click="isExpanded = true" class="w-fit! py-3!"
                        x-text="isExpanded ? 'Read less' : 'Read more'">{{ __('Read more') }}</x-ui.button>
                </div>
                <div x-show="isExpanded" x-transition class="mt-5">
                    <ul class="text-text-white text-xl font-normal ml-6 space-y-1 mb-6">
                        <li class="list-disc">{{ __('PixelStoreLAT') }}</li>
                        <li class="list-disc">{{ __('PixelStoreLAT1') }}</li>
                        <li class="list-disc">{{ __('PixelStoreLAT2') }}</li>
                        <li class="list-disc">{{ __('PixelStoreLAT3') }}</li>
                        <li class="list-disc">{{ __('PixelStoreLAT4') }}</li>
                        <li class="list-disc">{{ __('PixelStoreLAT5') }}</li>
                    </ul>

                    <div class="mb-6">
                        <p class="text-text-white text-xl font-normal mb-2">{{ __('📊 HOW TO ORDER CORRECTLY:') }}</p>
                        <p class="text-text-white text-xl font-normal mb-2">
                            {{ __(' Order a quantity that matches the V-Bucks value of the item you want.') }}
                        </p>
                        <p class="text-text-white text-xl font-normal mb-2">
                            {{ __('Example: if a skin costs 1000 V-Bucks, place an order for quantity 1000.') }}
                        </p>
                        <p class="text-text-white text-xl font-normal">
                            {{ __('Incorrect quantities will result in automatic cancellation and refund.') }}
                        </p>
                    </div>

                    <div class="mb-6">
                        <p class="text-text-white text-xl font-normal mb-2">{{ __('💎 HOW TO GIFT CORRECTLY:') }}</p>
                        <p class="text-text-white text-xl font-normal">
                            {{ __('After 48 hours of Epic friendship, send us your Epic username and a screenshot of the skin
                                                        you\'d like.') }}
                        </p>
                    </div>

                    <div class="mb-6">
                        <p class="text-text-white text-xl font-normal mb-2">{{ __('💤 OFFLINE NOTE:') }}</p>
                        <p class="text-text-white text-xl font-normal">
                            {{ __('If we appear offline, we\'re just away or asleep — your friend request will be accepted as
                                                        soon as possible!') }}
                        </p>
                    </div>

                    <div class="mb-6">
                        <p class="text-text-white text-xl font-normal mb-2">{{ __('✅ SAFE & LEGAL GIFTING:') }}</p>
                        <p class="text-text-white text-xl font-normal mb-2">
                            {{ __('All gifts are sent through the official Fortnite gifting system.') }}
                        </p>
                        <p class="text-text-white text-xl font-normal mb-2">
                            {{ __('Only shop-available cosmetics purchasable with V-Bucks are eligible.') }}
                        </p>
                        <p class="text-text-white text-xl font-normal">
                            {{ __('Works across all platforms (PC, Console, Mobile).') }}
                        </p>
                    </div>

                    <div class="mb-6">
                        <p class="text-text-white text-xl font-normal mb-2">{{ __('🎉 POPULAR TAGS:') }}</p>
                        <p class="text-text-white text-xl font-normal leading-relaxed">
                            {{ __(' fortnite-vbucks-gift, fortnite-skins-sale, vbucks-discount, fortnite-shop-deals,
                                                        gaming-gifts, vbucks-promo, fortnite-deals, fortnite-gifting, fortnite-items,
                                                        gaming-giftcards, cosmetics-sale, battle-royale-skins, gamer-gifts, vbucks-special,
                                                        fortnite-gift-ideas') }}
                        </p>
                    </div>
                    <div class="flex w-fit!">
                        <x-ui.button @click="isExpanded = false"
                            class="w-fit! py-3!">{{ __('Read less') }}</x-ui.button>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-bg-info px-4 sm:px-10 md:px-20 py-4 sm:py-10 rounded-2xl mt-20">
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
        <div class="bg-bg-info px-4 sm:px-10 md:px-20 py-4 sm:py-10 rounded-2xl mt-20">
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
    <div class="pb-10"></div>
</div>
