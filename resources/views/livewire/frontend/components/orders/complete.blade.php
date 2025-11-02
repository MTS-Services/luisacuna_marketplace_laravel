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
                            {{-- <h3 class="text-primary-50 text-2xl ">Mercury Spark — Ultimate 5-Star Boost</h3> --}}
                            <h3 class="text-primary-50 text-2xl ">Mercury Spark...</h3>
                            <p class="text-primary-50 text-base pt-2">
                                <span>Order ID:</span>
                                98bc4674-4bde
                                {{-- 98bc4674-4bde-4498-9175-a4a0318458e0 --}}
                            </p>
                        </div>
                    </div>
                    <div class="button">
                        <x-ui.button :variant="'tertiary'" class="w-auto! bg-btn-danger!">Cancel Order</x-ui.button>
                    </div>

                </div>
            </div>

            <div class="item-details pb-10">
                <div class="flex gap-6 items-start flex-col md:flex-row">
                    <div class="details-left  w-full md:w-2/3">

                        <div class="bg-zinc-50 dark:bg-bg-base-50 rounded-3xl p-6 md:p-10 w-full ">
                            <div class="flex items-center pb-5">
                                <div
                                    class="w-16.5 h-16.5 flex items-center justify-center bg-bg-secondary dark:bg-bg-light rounded-full ">
                                    <flux:icon icon="check" class="w-7 h-7 text-primary-50"></flux:icon>
                                    {{-- <img src="{{ asset('assets/images/icons/Info.png') }}" alt="Info Icon" class="h-7 w-7"> --}}
                                </div>
                                <di class="pl-4">
                                    <p class="font-semibold  text-2xl">Order Cancelled</p>
                                    <p>
                                        <span class="text-xs text-primary-50 font-normal ">Jun 11, 2024 , </span>
                                        <span class="text-xs   text-primary-50 font-normal">1:22:12 AM</span>
                                    </p>
                                </di>
                            </div>
                            <p class="font-normal text-base text-primary-50">Order is marked as completed. Funds will be
                                added to your Eldorado balance.</p>
                        </div>

                        <div class="bg-zinc-50 dark:bg-bg-base-50 rounded-3xl p-6 md:p-10 w-full mt-6 ">
                            <div class="flex items-center pb-5">

                                <di class="pl-4">
                                    <p class="font-semibold  text-2xl"> {{ __('Buyer Feedback') }} </p>
                                </di>
                            </div>
                            <p class="font-normal text-base text-primary-50 flex px-6 py-4 bg-bg-light rounded-xl ">
                                <x-phosphor name="thumbs-up" class="text-secondary-100 mr-2" variant="solid" />
                                {{ __('GGWP !') }}
                            </p>
                        </div>

                        {{-- Chat --}}



                        <div class="chat mt-10 mb-16 px-6 md:px-20 py-10 bg-bg-light rounded-3xl">
                            <div class="mb-10">
                                <div
                                    class="py-7 px-7 rounded-3xl bg-zinc-50 dark:bg-bg-base flex flex-row justify-between items-center border-l-3 border-pink-500">
                                    <div class=" flex flex-row">
                                        <div class="relative mr-5">
                                            <img src="{{ asset('/assets/images/orders/2 2.png') }}"
                                                class="w-13.5 h-13.5" alt="">
                                            <span
                                                class="h-2 w-2 bg-bg-active absolute rounded-full right-0 bottom-2.5"></span>
                                        </div>
                                        <div>
                                            <p class="text-base md:text-xl font-semibold">{{ __('D18QUAN') }}</p>
                                            <p class="text-xs md:text-base">{{ __('Order for this') }}</p>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="relative hidden xl:block">
                                            <flux:icon name="magnifying-glass"
                                                class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 stroke-text-primary" />

                                            <input type="text" placeholder="Search coversation"
                                                class="border dark:border-white border-gray-600 rounded-full py-1.5 pl-8 pr-2 text-sm focus:outline-none focus:border-purple-500 focus:bg-bg-primary transition-all w-22 focus:w-64 bg-transparent placeholder:text-text-primary">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="w-full mb-10">
                                <div
                                    class="py-7 px-7 rounded-3xl bg-bg-base-50 flex flex-col border-l-4 border-pink-500 w-full">
                                    <div class="flex flex-col w-full ">
                                        <p class="text-text-primary break-all text-xs md:text-base">
                                            {{ __('Order Created: https//www_companyname_gWorder/98bc4674-4bde-4498-9175-a4a0318458eO') }}
                                        </p>

                                        <div class="mt-3 w-full bg-bg-light p-2 md:p-4 rounded-xl">
                                            <p class="flex items-center text-xs md:text-base">
                                                <flux:icon name="link" class="inline-block pr-2" />
                                                {{ __('98bc46744bde-4498-9175-a4a031U58eO') }}
                                            </p>
                                            <sub class="text-gray-500 text-xs md:text-base">
                                                {{ __('www.companyname.com') }}
                                            </sub>
                                        </div>

                                        <p class="mt-3 text-primary-50 text-right text-xs">{{ __('Oct-20-2025') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full mb-10">
                                <div
                                    class="py-7 px-7 rounded-3xl bg-bg-base-50 flex flex-col border-l-4 border-pink-500 w-full">
                                    <div class="flex flex-col w-full ">
                                        <div class="mt-3 w-full bg-bg-light p-2 md:p-4 rounded-xl">
                                            <p class="flex items-center text-xs md:text-base">
                                                <flux:icon name="link" class="inline-block pr-2" />
                                                {{ __('98bc46744bde-4498-9175-a4a031U58eO') }}
                                            </p>
                                            <p class="flex items-center text-xs md:text-base">
                                                <sub class="text-gray-500 ">
                                                    {{ __('www.companyname.com') }}
                                                </sub>
                                        </div>

                                        <p class="mt-3 text-primary-50 text-right text-xs">{{ __('Oct-20-2025') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-10">
                                <div class="py-7  rounded-3xl flex flex-row items-start">
                                    <div>
                                        <div class="relative mr-5">
                                            <img src="{{ asset('/assets/images/orders/2 2.png') }}"
                                                class="w-13.5 h-13.5" alt="">
                                            <span
                                                class="h-2 w-2 bg-bg-active absolute rounded-full right-0 bottom-2.5"></span>
                                        </div>
                                    </div>
                                    <div class="w-8/9">
                                        <div class="flex flex-col w-full ">
                                            <div class=" w-full bg-zinc-50 dark:bg-bg-light p-2 md:p-4 rounded-xl">
                                                <p class="flex items-center text-xs md:text-base">
                                                <p class="flex items-center text-xs md:text-base">

                                                    {{ __('98bc46744bde-4498-9175-a4a031U58eO') }}
                                                </p>
                                            </div>

                                            <p class="mt-3 text-primary-50 text-right text-xs">{{ __('Oct-20-2025') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-10">
                                <div class="py-7  rounded-3xl flex flex-row-reverse items-start">
                                    <div>
                                        <div class="relative ml-5">
                                            <img src="{{ asset('/assets/images/orders/2 2.png') }}"
                                                class="w-13.5 h-13.5" alt="">
                                            <span
                                                class="h-2 w-2 bg-bg-active absolute rounded-full right-0 bottom-2.5"></span>
                                        </div>
                                    </div>
                                    <div class="w-8/9">
                                        <div class="flex flex-col w-full ">
                                            <div class=" w-full bg-zinc-50 dark:bg-bg-light p-2 md:p-4 rounded-xl">
                                                <p class="flex items-center text-xs md:text-base">

                                                    {{ __('98bc46744bde-4498-9175-a4a031U58eO') }}
                                                </p>
                                            </div>

                                            <p class="mt-3 text-primary-50 text-left text-xs">{{ __('Oct-20-2025') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="w-full mb-10">
                                <div
                                    class="py-7 px-7 rounded-3xl bg-bg-base-50 flex flex-col border-l-4 border-pink-500 w-full">
                                    <div class="flex flex-col w-full ">
                                        <div class="mt-3 w-full  bg-bg-light p-2 md:p-4 rounded-xl">
                                            <p class="flex items-center text-xs md:text-base">
                                                <flux:icon name="link" class="inline-block pr-2" />
                                                {{ __('98bc46744bde-4498-9175-a4a031U58eO') }}
                                            </p>
                                            <sub class="text-gray-500 text-xs md:text-base">
                                                {{ __('www.companyname.com') }}
                                            </sub>
                                        </div>

                                        <p class="mt-3 text-primary-50 text-right text-xs">{{ __('Oct-20-2025') }}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="">
                                <div class="py-7  rounded-3xl ">

                                    <div class="flex flex-col w-full ">
                                        <div
                                            class=" w-full bg-zinc-50 dark:bg-bg-light p-2 md:p-4 rounded-xl flex justify-between text-xs md:text-base">
                                            <input type="text" placeholder="Say something......"
                                                class="text-primary-50">

                                            <p class="flex flex-nowrap">
                                                <x-phosphor name="link" class="text-secondary-100 mr-2"
                                                    variant="outline" />
                                                <x-phosphor name="smiley" class="text-secondary-100 mr-2"
                                                    variant="outline" />
                                                <x-phosphor name="paper-plane-tilt" class="text-secondary-100 mr-2"
                                                    variant="outline" />

                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>

                    <div class="detail-right w-full md:w-1/3 ">
                        <div class="p-7 bg-bg-base-50 rounded-3xl mb-6">
                            <div class="pb-6">
                                <p class="font-semibold text-2xl">Delivery Time</p>
                            </div>
                            <div class="flex flex-row justify-between gap-2 w-full">
                                <div class=" items-center border-r-3 border-r-primary w-1/3 ">
                                    <p class="font-bold text-3xl text-primary-50 text-center"> {{ __('7') }}</p>
                                    <p class="font-normal text-primary-50 text-center"> {{ __('Day') }}</p>
                                </div>
                                <div class=" items-center border-r-3 border-r-primary w-1/3 ">
                                    <p class="font-bold text-3xl text-primary-50 text-center"> {{ __('7') }}</p>
                                    <p class="font-normal text-primary-50 text-center"> {{ __('Hours') }}</p>
                                </div>
                                <div class=" items-center  w-1/3 ">
                                    <p class="font-bold text-3xl text-primary-50 text-center"> {{ __('7') }}</p>
                                    <p class="font-normal text-primary-50 text-center"> {{ __('Minutes') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-7 bg-bg-base-50 rounded-3xl">
                            <div class="pb-6">
                                <p class="font-semibold text-2xl">Order Details</p>
                            </div>
                            <div>
                                <div class="flex justify-between pb-3">
                                    <p class="text-base">Game</p>
                                    <p class="flex flex-end">
                                        <span class="logo"><img
                                                src="{{ asset('assets/images/icons/Rectangle 12419.png') }}"
                                                alt="" class="w-6 h-6"></span>
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
                            </div>
                            <div class="pt-10">
                                <x-ui.button :variant="'primary'"
                                    class="!bg-btn-primary !border-none hover:!text-primary-50">
                                    View Full Description
                                    <flux:icon icon="arrow-right" class="inline-block pl-3 !text-primary-50">
                                    </flux:icon>
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>



    </div>
</section>
