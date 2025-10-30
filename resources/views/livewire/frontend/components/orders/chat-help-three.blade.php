<section>
    <div class="container">
        <div class="breadcrumb pb-7 md:pb-50">
            <div class="back pt-10">

                <a href="javascript:void(0)" wire:navigate class="text-primary-50 text-md ">
                    <flux:icon icon="arrow-left" class="inline-block pr-2" />
                    {{ __('Back') }}
                </a>
            </div>
        </div>

        <div class="item ">


            <div class="item-details pb-10">
                <div class="w-full bg-bg-light dark:bg-bg-base-50 rounded-3xl p-4 md:p-20">

                    <div class="item-title pb-10">
                        <div class="item-short-info flex justify-between">
                            <div class="flex flex-nowrap">
                                <div class="item-image">
                                    <img src="{{ asset('assets/images/icons/Rectangle 12419.png') }}"
                                        alt="Mercury Spark — Ultimate 5-Star Boost" class="h-10 w-10">
                                </div>
                                <div class="item-title pl-5">
                                    <h3 class="text-primary-50 text-2xl ">Fortunite</h3>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="detail-right w-full p-7 bg-zinc-50 dark:bg-bg-light  rounded-3xl">

                        <div class="item-title pb-10">
                            <div class="item-short-info flex justify-between">
                                <div class="flex flex-nowrap">
                                    <div class="item-image">
                                        <img src="{{ asset('assets/images/orders/Rectangle 12420.png') }}"
                                            alt="Mercury Spark — Ultimate 5-Star Boost" class="h-10 w-10">
                                    </div>
                                    <div class="item-title pl-5">
                                        <h3 class="text-primary-50 text-base md:text-2xl ">Mercury Spark — Ultimate
                                            5-S..</h3>
                                        {{-- <h3 class="text-primary-50 text-2xl ">Mercury Spark — Ultimate 5-Star Boost</h3> --}}

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div>

                            <div class="flex justify-between pb-3">
                                <p class="text-base">Username</p>
                                <p class="flex flex-end">
                                    <span class="text-xs md:text-base pl-3">acuzane</span>
                                </p>
                            </div>
                            <div class="flex justify-between pb-3">
                                <p class="text-base">Device </p>
                                <p class="flex flex-end">
                                    <span class="text-xs md:text-base pl-3">Pc</span>
                                </p>
                            </div>
                            <div class="flex justify-between pb-3">
                                <p class="text-base">Quantity</p>
                                <p class="flex flex-end">
                                    <span class="text-xs md:text-base pl-3">6</span>
                                </p>
                            </div>
                            <div class="flex justify-between pb-3">
                                <p class="text-base">Guaranteed Delivery time</p>
                                <p class="flex flex-end">
                                    <span class="text-xs md:text-base pl-3"> 1 Days </span>
                                </p>
                            </div>
                            <div class="flex justify-between pb-3">
                                <p class="text-base">Delivery Method</p>
                                <p class="flex flex-end">
                                    <span class="text-xs md:text-base pl-3"> in-game Delivery </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="item-list mt-10">
                        <div class="w-full flex flex-col">
                            <div class="p-2 ">
                                <img src="{{ asset('assets/images/orders/Mercury_LMG_-_Schematic_-_Save_the_World .png') }}"
                                    alt="">
                            </div>
                            <div class="pl-2">
                                <p class="mt-6 font-semibold text-xl"> {{ __('Description') }}</p>
                                <div>
                                    <p class="text-base md:text-xl text-primary-50 mt-5">🚨 IMPORTANT — PLEASE READ
                                        BEFORE ORDERING TO AVOID CANCELLATION OR REFUND! 🚨
                                    </p>
                                    <p class="text-base md:text-xl  text-primary-50 mt-5">
                                        🔴 FRIENDSHIP REQUIRED: To follow Epic Games’ gifting policy, we must be Epic
                                        friends for at least 48 hours before sending gifts.
                                        Please send friend requests to all of these accounts:
                                        AcuZone Twitch
                                        PixelStoreLAT1
                                        PixelStoreLAT2
                                        PixelStoreLAT3
                                        PixelStoreLAT4
                                        PixelStoreLAT5
                                    </p>
                                    <p class="text-base md:text-xl  text-primary-50 mt-5">

                                        🛒 HOW TO ORDER CORRECTLY: Order a quantity that matches the V-Bucks value of
                                        the item you want. Example: If a skin costs 1000 V-Bucks, place an order for
                                        quantity 1000. Incorrect quantities will result in automatic cancellation and
                                        refund.

                                        🎯 HOW TO RECEIVE YOUR SKIN: After 48 hours of Epic friendship, send us your
                                        Epic username and a screenshot of the skin you’d like.
                                    </p>
                                    <p class="text-base md:text-xl  text-primary-50 mt-5">

                                        💤 OFFLINE NOTE: If we appear offline, we’re just away or asleep — your friend
                                        request will be accepted as soon as possible!
                                    </p>
                                    <p class="text-base md:text-xl  text-primary-50 mt-5">

                                        ✅ SAFE & LEGAL GIFTING: All gifts are sent through the official Fortnite gifting
                                        system. Only shop-available cosmetics purchasable with V-Bucks are eligible.
                                        Works across all platforms (PC, Console, Mobile).
                                    </p>
                                    <p class="text-base md:text-xl  text-primary-50 mt-5">
                                        🕹️ TAGS (Ignore): fortnite-vbucks-gift, fortnite-skins-sale, vbucks-discount,
                                        fortnite-shop-deals, gaming-gifts, vbucks-promo, fortnite-deals,
                                        fortnite-gifting, fortnite-items, gaming-giftcards, cosmetics-sale,
                                        battle-royale-skins, gamer-gifts, vbucks-special, fortnite-gift-ideas
                                    </p>
                                </div>
                            </div>
                            <div class="button">
                                <x-ui.button :variant="'primary'" class="inline-block! mt-10 w-auto! ">Read
                                    more</x-ui.button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="payment-info w-full p-4 md:p-20 bg-bg-light rounded-3xl mb-10">

                <div class="item-title pb-5">
                    <div class="item-short-info flex justify-between">
                        <div class="flex flex-nowrap">

                            <div class="item-title ">

                                <h3 class="text-primary-50 text-2xl ">{{ __('Seller') }}</h3>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="  rounded-3xl flex flex-row items-start">
                    <div>
                        <div class="relative mr-5">
                            <img src="{{ asset('/assets/images/orders/2 2.png') }}" class="w-13.5 h-13.5"
                                alt="">
                            <span class="h-2 w-2 bg-bg-active absolute rounded-full right-0 bottom-2.5"></span>
                        </div>
                    </div>
                    <div class="w-8/9">
                        <div class="flex flex-col w-full ">
                            <div class=" w-full ">
                                <p class="flex items-center">
                                    {{ __('Sohan') }}
                                </p>
                                <p class="pt-2">
                                    <span class="pr-2 text-xs font-normal ">Like |</span>
                                    <span class="pr-2 text-xs font-normal ">2434 Reviews |</span>
                                    <span class="text-xs font-normal">1642 Sold</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="payment-info w-full p-4 md:p-20 bg-bg-light  rounded-3xl  mb-25">

                <div class="item-title pb-10">
                    <div class="item-short-info flex justify-between">
                        <div class="flex flex-nowrap">

                            <div class="item-title ">

                                <h3 class="text-primary-50 text-2xl ">{{ __('Payment') }}</h3>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="w-full ">

                    <div class="flex justify-between pb-3">
                        <p class="text-base">Total Price</p>
                        <p class="flex flex-end">
                            <span class="text-xs md:text-base pl-3"> $ <span> {{ __('1.20') }}</span></span>
                        </p>
                    </div>
                    <div class="flex justify-between pb-3">
                        <p class="text-base">Payment Fee </p>
                        <p class="flex flex-end">
                            <span class="text-xs md:text-base pl-3">0.00</span>
                        </p>
                    </div>
                    <div class="flex justify-between pb-3">
                        <p class="text-base">Quantity</p>
                        <p class="flex flex-end">
                            <span class="text-xs md:text-base pl-3">6</span>
                        </p>
                    </div>
                    <div class="flex justify-between pb-3">
                        <p class="text-base">Guaranteed Delivery time</p>
                        <p class="flex flex-end">
                            <span class="text-xs md:text-base pl-3"> 1 Days </span>
                        </p>
                    </div>
                    <div class="flex justify-between pb-3">
                        <p class="text-base">Company Balance</p>
                        <p class="flex flex-end">
                            <span class="text-xs md:text-base pl-3"> in-game Delivery </span>
                        </p>
                    </div>
                    <div class="flex justify-between pb-3 border-t-2 border-zinc-500">
                        <p class="text-base">Total:</p>
                        <p class="flex flex-end">
                            <span class="text-xs md:text-base pl-3"> $ 0.00 </span>
                        </p>
                    </div>
                </div>
            </div>




        </div>
</section>
