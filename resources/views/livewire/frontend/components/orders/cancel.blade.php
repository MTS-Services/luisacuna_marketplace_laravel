<section>
    <div class="container">
        <div class="breadcrumb">
            <div class="back py-10">

                <a href="javascript:void(0)" wire:navigate class="text-primary-50 text-xl ">
                    <flux:icon icon="arrow-left" class="inline-block pr-2" />
                    {{ __('All Orders') }}
                </a>
            </div>
        </div>

        <div class="item ">
            <div class="item-title pb-10">
                <div class="item-short-info flex justify-between">
                    <div class="flex flex-nowrap">
                        <div class="item-image">
                            <img src="{{ asset('assets/images/orders/Rectangle 12420.png') }}"
                                alt="Mercury Spark — Ultimate 5-Star Boost">
                        </div>
                        <div class="item-title pl-5">
                            <h3 class="text-primary-50 text-2xl ">Mercury Spar...</h3>
                            {{-- <h3 class="text-primary-50 text-2xl ">Mercury Spark — Ultimate 5-Star Boost</h3> --}}
                            <p class="text-primary-50 text-base pt-2">
                                <span>Order ID:</span>
                                98bc4674-
                                {{-- 98bc4674-4bde-4498-9175-a4a0318458e0 --}}
                            </p>
                        </div>
                    </div>
                    <div class="button">
                        <x-ui.button :variant="'tertiary'" class="w-auto! ">Cancel Order</x-ui.button>
                    </div>

                </div>
            </div>

            <div class="item-details pb-10">
                <div class="flex gap-6 flex-col md:flex-row items-start ">
                    <div class="details-left bg-zinc-50 dark:bg-bg-base-50 w-full md:w-2/3 p-10  rounded-3xl">
                        <div class="flex items-center pb-5">
                            <div
                                class="w-16.5 h-16.5 flex items-center justify-center bg-bg-secondary dark:bg-bg-light rounded-full ">
                                <img src="{{ asset('assets/images/icons/Info.png') }}" alt="Info Icon" class="h-7 w-7">
                            </div>
                            <p class="font-semibold pl-4 text-2xl">Order Cancelled</p>
                        </div>

                        <div class="pb-5">
                            <label class="pb-3 text-base">Dispute reason</label>
                            <p class="font-bold text-primary-50 text-base md:text-2xl">I have another issues.</p>
                        </div>
                        <div class="pb-5">
                            <label class="pb-3 text-base">Canceled by</label>
                            <p class="font-bold text-primary-50 text-base md:text-2xl">Seller</p>
                        </div>
                        <div class="pb-5">
                            <label class="pb-3 text-base">Canceled reason</label>
                            <p class="font-bold text-primary-50 text-base md:text-2xl">Others</p>
                        </div>
                        <div class="pb-5">
                            <label class="pb-3 text-base">Comment </label>
                            <p class="font-bold text-primary-50 text-base md:text-2xl">Buyer Requested to cancle the
                                order </p>
                        </div>
                    </div>
                    <div class="detail-right w-full md:w-1/3 p-7 bg-bg-base-50 rounded-3xl mt-6 md:mt-0">
                        <div class="pb-6">
                            <p class="font-semibold text-2xl">Order Cancelled</p>
                        </div>
                        <div>
                            <div class="flex justify-between pb-3">
                                <p class="text-base">Game</p>
                                <p class="flex flex-end">
                                    <span class="logo"><img
                                            src="{{ asset('assets/images/icons/Rectangle 12419.png') }}" alt=""
                                            class="w-6 h-6"></span>
                                    <span class="text-base pl-3">Fortunite</span>
                                </p>
                            </div>
                            <div class="flex justify-between pb-3">
                                <p class="text-base">Username</p>
                                <p class="flex flex-end">
                                    <span class="text-base pl-3">acuzane</span>
                                </p>
                            </div>
                            <div class="flex justify-between pb-3">
                                <p class="text-base">Device Name</p>
                                <p class="flex flex-end">
                                    <span class="text-base pl-3">Pc</span>
                                </p>
                            </div>
                            <div class="flex justify-between pb-3">
                                <p class="text-base">Quantity</p>
                                <p class="flex flex-end">
                                    <span class="text-base pl-3">6</span>
                                </p>
                            </div>
                            <div class="flex justify-between pb-3">
                                <p class="text-base">Seller</p>
                                <p class="flex flex-end items-center">
                                    <span class="text-base text-btn-danger pl-3 ">D18QUAN</span>
                                    <span class="w-3 h-3 rounded-full bg-bg-active ml-3"></span>
                                    <span class="text-base pl-1">

                                        Online
                                    </span>
                                </p>
                            </div>
                            <div class="flex justify-between pb-3">
                                <p class="text-base">Total Price</p>
                                <p class="flex flex-end">
                                    <span class="text-base pl-3">$ <span>1.20</span></span>
                                </p>
                            </div>
                        </div>
                        <div class="pt-10">
                            <x-ui.button :variant="'primary'"
                                class="w-auto! bg-btn-primary! border-none! hover:text-primary-50!">
                                View Full Description
                                <flux:icon icon="arrow-right" class="inline-block! pl-3 text-primary-50!"></flux:icon>
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="additional-info pb-10">
                <ul class="list-disc ml-6 pb-10">
                    <li class="text-primary-50 text-xl pb-3 ">You received a refund for this order in your <span
                            class="text-btn-danger">“Company name”</span> balance</li>
                    <li class="text-primary-50 text-xl pb-3 ">When you place a new order, your balance will be used
                        automatically</li>
                    <li class="text-primary-50 text-xl pb-3 ">You will not be charged payment fees again</li>
                </ul>
                <x-ui.button class="!w-40 !inline-block mb-3" :variant="'primary'">
                    Buy Again
                    <flux:icon name="arrow-right" class="inline-block pl-3"></flux:icon>
                </x-ui.button>
                <p>
                    <span>Note: </span>
                    <span>Spend your <span class="text-btn-danger">"Company name"</span> balance</span>
                </p>
            </div>
        </div>


        <div class="chat mt-10 mb-16 px-7 py-10 bg-bg-light rounded-3xl">
            <div class="mb-10">
                <div class="py-7 px-7 rounded-3xl bg-zinc-50 dark:bg-bg-base flex flex-row border-l-3 border-pink-500">
                    <div class="relative mr-5">
                        <img src="{{ asset('/assets/images/orders/2 2.png') }}" class="w-13.5 h-13.5" alt="">
                        <span class="h-2 w-2 bg-bg-active absolute rounded-full right-0 bottom-2.5"></span>
                    </div>
                    <div>
                        <p class="text-xl font-semibold">{{ __('D18QUAN') }}</p>
                        <p class="text-base">{{ __('Order for this') }}</p>
                    </div>
                </div>
            </div>
            <div class="w-full mb-10">
                <div class="py-7 px-7 rounded-3xl bg-bg-base-50 flex flex-col border-l-4 border-pink-500 w-full">
                    <div class="flex flex-col w-full ">
                        <p class="text-text-primary break-all">
                            {{ __('Order Created: https//www_companyname_gWorder/98bc4674-4bde-4498-9175-a4a0318458eO') }}
                        </p>

                        <div class="mt-3 w-full bg-bg-light p-4 rounded-xl">
                            <p class="flex items-center text-base">
                                <flux:icon name="link" class="inline-block pr-2" />
                                {{ __('98bc46744bde-4498-9175-a4a031U58eO') }}
                            </p>
                            <sub class="text-gray-500 text-base">
                                {{ __('www.companyname.com') }}
                            </sub>
                        </div>

                        <p class="mt-3 text-primary-50 text-right">{{ __('Oct-20-2025') }}</p>
                    </div>
                </div>
            </div>
            <div class="w-full mb-10">
                <div class="py-7 px-7 rounded-3xl bg-bg-base-50 flex flex-col border-l-4 border-pink-500 w-full">
                    <div class="flex flex-col w-full ">
                        <div class="mt-3 w-full bg-bg-light p-4 rounded-xl">
                            <p class="flex items-center">
                                <flux:icon name="link" class="inline-block pr-2" />
                                {{ __('98bc46744bde-4498-9175-a4a031U58eO') }}
                            </p>
                            <sub class="text-gray-500">
                                {{ __('www.companyname.com') }}
                            </sub>
                        </div>

                        <p class="mt-3 text-primary-50 text-right">{{ __('Oct-20-2025') }}</p>
                    </div>
                </div>
            </div>

            <div class="mb-10">
                <div class="py-7  rounded-3xl flex flex-row items-start">
                    <div>
                        <div class="relative mr-5">
                            <img src="{{ asset('/assets/images/orders/2 2.png') }}" class="w-13.5 h-13.5"
                                alt="">
                            <span class="h-2 w-2 bg-bg-active absolute rounded-full right-0 bottom-2.5"></span>
                        </div>
                    </div>
                    <div class="w-8/9">
                        <div class="flex flex-col w-full ">
                            <div class=" w-full bg-zinc-50 dark:bg-bg-light p-4 rounded-xl">
                                <p class="flex items-center">

                                    {{ __('98bc46744bde-4498-9175-a4a031U58eO') }}
                                </p>
                            </div>

                            <p class="mt-3 text-primary-50 text-right">{{ __('Oct-20-2025') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-10">
                <div class="py-7  rounded-3xl flex flex-row-reverse items-start">
                    <div>
                        <div class="relative ml-5">
                            <img src="{{ asset('/assets/images/orders/2 2.png') }}" class="w-13.5 h-13.5"
                                alt="">
                            <span class="h-2 w-2 bg-bg-active absolute rounded-full right-0 bottom-2.5"></span>
                        </div>
                    </div>
                    <div class="w-8/9">
                        <div class="flex flex-col w-full ">
                            <div class=" w-full bg-zinc-50 dark:bg-bg-light p-4 rounded-xl">
                                <p class="flex items-center">

                                    {{ __('98bc46744bde-4498-9175-a4a031U58eO') }}
                                </p>
                            </div>

                            <p class="mt-3 text-primary-50 text-left">{{ __('Oct-20-2025') }}</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="w-full mb-10">
                <div class="py-7 px-7 rounded-3xl bg-bg-base-50 flex flex-col border-l-4 border-pink-500 w-full">
                    <div class="flex flex-col w-full ">
                        <div class="mt-3 w-full  bg-bg-light p-4 rounded-xl">
                            <p class="flex items-center">
                                <flux:icon name="link" class="inline-block pr-2" />
                                {{ __('98bc46744bde-4498-9175-a4a031U58eO') }}
                            </p>
                            <sub class="text-gray-500">
                                {{ __('www.companyname.com') }}
                            </sub>
                        </div>

                        <p class="mt-3 text-primary-50 text-right">{{ __('Oct-20-2025') }}</p>
                    </div>
                </div>
            </div>


            <div class="">
                <div class="py-7  rounded-3xl ">

                    <div class="flex flex-col w-full ">
                        <div class=" w-full bg-zinc-50 dark:bg-bg-light p-4 rounded-xl">
                            <p class="flex items-center">

                                {{ __('this conversation is no longer active. ') }}
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="secruity-tips pb-25">
            <div class="w-full mb-10">
                <div class="py-7 px-7 rounded-3xl bg-bg-light flex flex-col w-full">
                    <div class="flex flex-col w-full ">
                        <div class="mt-3 w-full ">
                            <p class="flex items-center text-3xl text-primary-50 font-semibold">
                                <img src="{{ asset('assets/images/icons/Rectangle 12420.png') }}" alt=""
                                    class="w-17 h-17">
                                {{ __('Security tips') }}
                            </p>
                        </div>
                        <p class="text-base text-primary-50 regular ">
                            {{ __('For your protection, you must always pay and communicate directly through the Eldorado website. If you stay on Eldorado throughout the entire transaction—from payment, to communication, to delivery—you are protected by Tradeshield. Additionally, be aware that sellers will never ask for your currency or items back after the order is delivered, so you should not respond to any messages requesting this.') }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
