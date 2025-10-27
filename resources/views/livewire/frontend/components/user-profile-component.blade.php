<main class=" mx-auto relative">
    <section class="">
        <div class="inner_banner">
            <img src="{{ asset('assets/images/user_profile/inner_banner.png') }}" alt="" class="w-full">
        </div>
    </section>
    {{-- profile header --}}
    <section class="container mx-auto bg-zinc-900 p-10! rounded-2xl absolute top-20 left-1/2 translate-x-[-50%] ">
        <div class="flex justify-between">
            <div class="flex items-center gap-6">
                <div class="">
                    <div class="relative">
                        <img src="{{ asset('assets/images/user_profile/Ellipse 474.png') }}" alt="">
                        <div class="absolute -right-3 top-20">
                            <img src="{{ asset('assets/images/user_profile/Frame 1261153813.png') }}" alt="">
                        </div>
                    </div>

                </div>
                <div class="">
                    <h3 class="text-4xl font-semibold mb-2">Starriz.clo</h3>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#12D212"
                            class="w-10 h-10 text-zinc-200/50">
                            <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                        </svg>
                        <span class="text-base-400">Online</span>
                    </div>
                    
                </div>
            </div>
            <div class="icon">
                <x-flux::icon name="pencil-square" class="w-6 h-6 inline-block" stroke="white" />
            </div>
        </div>
        <div class="border-b border-zinc-700 mt-6 mb-4"></div>
        <div class="flex gap-6">
            <a href="#" class=" group">
                <span class="relative z-10 ">Shop</span>
                <span class=""></span>
            </a>
            <a href="#" class=" group">
                <span class="relative z-10">Reviews</span>
                <span class=""></span>
            </a>
            <a href="#" class=" group">
                <span class="relative z-10">About</span>
                <span class=""></span>
            </a>
        </div>
    </section>
    <div class="min-h-70"></div>
    {{-- info --}}
    <section class="container mx-auto mb-30 mt-10 sm:mt-16 md:mt-20 lg:mt-24 xl:mt-30">
        <div class="mb-6">
            <h3 class="text-4xl text-zinc-50 mb-4">Shop</h3>
            {{-- profile nav --}}
            <div class="flex gap-3 sm:gap-6 items-start">
                <button wire:navigate wire:click="switchTab('currency')" class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'currency' ? 'bg-zinc-500' : 'bg-zinc-800' }} b rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/vector.png') }}" alt="Currency Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">Currency (0)</h3>
                </button>

                <button wire:navigate wire:click="switchTab('account')" class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'account' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download (4) 1.png') }}" alt="Account Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">Account (0)</h3>
                </button>

                <button wire:navigate wire:click="switchTab('items')" class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'items' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download 1.png') }}" alt="Items Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">Items (0)</h3>
                </button>

                <button wire:navigate wire:click="switchTab('topups')" class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'topups' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download (2) 1.png') }}" alt="Top Ups Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">Top Ups (0)</h3>
                </button>

                <button wire:navigate wire:click="switchTab('giftcards')" class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'giftcards' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download (1) 1.png') }}" alt="Gift Cards Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">Gift Cards (0)</h3>
                </button>
            </div>
            @if ($activeTab === 'currency')
                {{-- select game --}}
                <div class="w-full sm:w-sm md:w-md lg:w-md mt-6 border-2 border-zinc-800 rounded-lg">
                    <select name="" id="" class="w-full p-2">
                        <option value="All Game">All Game</option>
                    </select>
                </div>

                {{-- games --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-10">
                    <div class="bg-zinc-900 rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-zinc-50/95 text-base-600 font-semibold">PlayStation</span>
                            </div>
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-10 h-10 text-zinc-200/50">
                                        <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                    </svg>
                                    <span class="text-zinc-200/50 text-base-600">Stacked</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mt-5">
                            <span class="text-base-400 text-zinc-50">
                                Galaxy Skin – PSN / Xbox / PC Full Access
                            </span>
                            <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold text-zinc-50">
                                    PEN175.27
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 text-zinc-50/50" />
                                <span class="text-xs-400 text-zinc-50/50">
                                    Instant
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-zinc-900 rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">Xbox</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-zinc-200/50">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-zinc-200/50 text-base-600">Stacked</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400 text-zinc-50">
                                Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold text-zinc-50">
                                    PEN175.27
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 text-zinc-50/50" />
                                <span class="text-xs-400 text-zinc-50/50">
                                    Instant
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-zinc-900 rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">Xbox</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-zinc-200/50">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-zinc-200/50 text-base-600">Stacked</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400 text-zinc-50">
                                Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold text-zinc-50">
                                    PEN175.27
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 text-zinc-50/50" />
                                <span class="text-xs-400 text-zinc-50/50">
                                    Instant
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-zinc-900 rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">Xbox</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-zinc-200/50">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-zinc-200/50 text-base-600">Stacked</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400 text-zinc-50">
                                Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold text-zinc-50">
                                    PEN175.27
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 text-zinc-50/50" />
                                <span class="text-xs-400 text-zinc-50/50">
                                    Instant
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-zinc-900 rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">Xbox</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-zinc-200/50">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-zinc-200/50 text-base-600">Stacked</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400 text-zinc-50">
                                Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold text-zinc-50">
                                    PEN175.27
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 text-zinc-50/50" />
                                <span class="text-xs-400 text-zinc-50/50">
                                    Instant
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-zinc-900 rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">Xbox</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-zinc-200/50">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-zinc-200/50 text-base-600">Stacked</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400 text-zinc-50">
                                Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold text-zinc-50">
                                    PEN175.27
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 text-zinc-50/50" />
                                <span class="text-xs-400 text-zinc-50/50">
                                    Instant
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-zinc-900 rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">Xbox</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-zinc-200/50">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-zinc-200/50 text-base-600">Stacked</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400 text-zinc-50">
                                Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold text-zinc-50">
                                    PEN175.27
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 text-zinc-50/50" />
                                <span class="text-xs-400 text-zinc-50/50">
                                    Instant
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-zinc-900 rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">Xbox</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-zinc-200/50">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-zinc-200/50 text-base-600">Stacked</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400 text-zinc-50">
                                Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold text-zinc-50">
                                    PEN175.27
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 text-zinc-50/50" />
                                <span class="text-xs-400 text-zinc-50/50">
                                    Instant
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-zinc-900 rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">Xbox</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-zinc-200/50">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-zinc-200/50 text-base-600">Stacked</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400 text-zinc-50">
                                Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold text-zinc-50">
                                    PEN175.27
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 text-zinc-50/50" />
                                <span class="text-xs-400 text-zinc-50/50">
                                    Instant
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- account --}}

            @if ($activeTab === 'account')
                <div class="mt-6 flex items-center gap-4">
                    <div class="w-md border-2 border-zinc-800 rounded-lg">
                        <select name="" id="" class="w-full p-2">
                            <option value="Search">Search</option>
                        </select>
                    </div>
                    <div class="w-md border-2 border-zinc-800 rounded-lg">
                        <select name="" id="" class="w-full p-2">
                            <option value="All Game">All Game</option>
                        </select>
                    </div>
                </div>
                <div class="mt-10">
                    <div class="">
                        <img src="{{ asset('assets/images/user_profile/not_found.jpg') }}" alt=""
                            class="rounded-2xl w-full">
                    </div>
                </div>
            @endif


            {{-- Items --}}
            @if ($activeTab === 'items')
                <div class="mt-6 flex items-center gap-4">
                    <div class="w-md border-2 border-zinc-800 rounded-lg">
                        <select name="" id="" class="w-full p-2">
                            <option value="Search">Search</option>
                        </select>
                    </div>
                    <div class="w-md border-2 border-zinc-800 rounded-lg">
                        <select name="" id="" class="w-full p-2">
                            <option value="All Game">All Game</option>
                        </select>
                    </div>
                </div>
                <div class="mt-10">
                    <div class="">
                        <img src="{{ asset('assets/images/user_profile/not_found.jpg') }}" alt=""
                            class="rounded-2xl w-full">
                    </div>
                </div>
            @endif


            {{-- Top ups --}}
            @if ($activeTab === 'topups')
                <div class="mt-6 flex items-center gap-4">
                    <div class="w-md border-2 border-zinc-800 rounded-lg">
                        <select name="" id="" class="w-full p-2">
                            <option value="Search">Search</option>
                        </select>
                    </div>
                    <div class="w-md border-2 border-zinc-800 rounded-lg">
                        <select name="" id="" class="w-full p-2">
                            <option value="All Game">All Game</option>
                        </select>
                    </div>
                </div>
                <div class="mt-10">
                    <div class="">
                        <img src="{{ asset('assets/images/user_profile/not_found.jpg') }}" alt=""
                            class="rounded-2xl w-full">
                    </div>
                </div>
            @endif


            {{-- gift cards --}}
            @if ($activeTab === 'giftcards')
                <div class="mt-6 flex items-center gap-4">
                    <div class="w-md border-2 border-zinc-800 rounded-lg">
                        <select name="" id="" class="w-full p-2">
                            <option value="Search">Search</option>
                        </select>
                    </div>
                    <div class="w-md border-2 border-zinc-800 rounded-lg">
                        <select name="" id="" class="w-full p-2">
                            <option value="All Game">All Game</option>
                        </select>
                    </div>
                </div>
                <div class="mt-10">
                    <div class="">
                        <img src="{{ asset('assets/images/user_profile/not_found.jpg') }}" alt=""
                            class="rounded-2xl w-full">
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>
