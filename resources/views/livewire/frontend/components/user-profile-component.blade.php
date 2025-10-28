<main class=" mx-auto relative">
    <section class="">
        <div class="inner_banner h-16 sm:h-32">
            <img src="{{ asset('assets/images/user_profile/inner_banner.png') }}" alt="" class="w-full h-full">
        </div>
    </section>
    {{-- profile header --}}
    <section
        class="container mx-auto bg-bg-primary p-10 rounded-2xl absolute left-1/2 -translate-x-1/2 top-10 sm:top-5 md:top-15">
        <div class="flex justify-between">
            <div class="flex items-center gap-6">
                <div class="">
                    <div class="relative">
                        <div class="w-20 h-20 sm:w-40 sm:h-40">
                            <img src="{{ asset('assets/images/user_profile/Ellipse 474.png') }}" alt=""
                                class="h-full w-full">
                        </div>
                        <div class="absolute -right-5 top-7 sm:-right-3 sm:top-20 w-10 h-10 sm:w-15 sm:h-15">
                            <img src="{{ asset('assets/images/user_profile/Frame 1261153813.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                    </div>

                </div>
                <div class="">
                    <h3 class="text-4xl font-semibold text-text-white mb-2">Starriz.clo</h3>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#12D212"
                            class="w-10 h-10 text-text-secondary">
                            <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                        </svg>
                        <span class="text-base-400 text-text-white">Online</span>
                    </div>

                </div>
            </div>
            <div class="icon">
                <x-flux::icon name="pencil-square" class="w-6 h-6 inline-block" stroke="white" />
            </div>
        </div>
        <div class="border-b border-zinc-700 mt-6 mb-4"></div>
        <div class="flex gap-6">
            <button wire:navigate wire:click="switchInnerMenu('shop')"
                class="navbar_style  {{ $activeInnerMenu === 'shop' ? 'active' : '' }} group">
                <span class="relative z-10 text-text-white ">Shop</span>
                <span class="navbar_style"></span>
            </button>
            <button wire:navigate wire:click="switchInnerMenu('reviews')"
                class=" navbar_style {{ $activeInnerMenu === 'reviews' ? 'active' : '' }} group">
                <span class="relative z-10 text-text-white ">Reviews</span>
                <span class=""></span>
            </button>
            <button wire:navigate wire:click="switchInnerMenu('about')"
                class=" navbar_style {{ $activeInnerMenu === 'about' ? 'active' : '' }} group">
                <span class="relative z-10 text-text-white ">About</span>
                <span class=""></span>
            </button>
        </div>
    </section>
    {{-- about --}}
    <div class="min-h-70"></div>
    {{-- shop --}}
    @if ($activeInnerMenu === 'shop')
        <section class="container mx-auto mb-30 mt-10 sm:mt-16 md:mt-20 lg:mt-24 xl:mt-30">
            <div class="mb-6">
                <h3 class="text-4xl mb-4">Shop</h3>
                {{-- profile nav --}}
                <div class="flex gap-3 sm:gap-6 items-start">
                    <button wire:navigate wire:click="switchTab('currency')" class="flex flex-col items-center">
                        <div
                            class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'currency' ? 'bg-zinc-500' : 'bg-zinc-800' }} b rounded-xl flex items-center justify-center">
                            <img src="{{ asset('assets/images/user_profile/vector.png') }}" alt="Currency Icon"
                                class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                        </div>
                        <h3 class="text-sm font-medium whitespace-nowrap">Currency (0)</h3>
                    </button>

                    <button wire:navigate wire:click="switchTab('account')" class="flex flex-col items-center">
                        <div
                            class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'account' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                            <img src="{{ asset('assets/images/user_profile/download (4) 1.png') }}" alt="Account Icon"
                                class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                        </div>
                        <h3 class="text-sm font-medium whitespace-nowrap">Account (0)</h3>
                    </button>

                    <button wire:navigate wire:click="switchTab('items')" class="flex flex-col items-center">
                        <div
                            class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'items' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                            <img src="{{ asset('assets/images/user_profile/download 1.png') }}" alt="Items Icon"
                                class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                        </div>
                        <h3 class="text-sm font-medium whitespace-nowrap">Items (0)</h3>
                    </button>

                    <button wire:navigate wire:click="switchTab('topups')" class="flex flex-col items-center">
                        <div
                            class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'topups' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                            <img src="{{ asset('assets/images/user_profile/download (2) 1.png') }}" alt="Top Ups Icon"
                                class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                        </div>
                        <h3 class="text-sm font-medium whitespace-nowrap">Top Ups (0)</h3>
                    </button>

                    <button wire:navigate wire:click="switchTab('giftcards')" class="flex flex-col items-center">
                        <div
                            class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'giftcards' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                            <img src="{{ asset('assets/images/user_profile/download (1) 1.png') }}"
                                alt="Gift Cards Icon" class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                        </div>
                        <h3 class="text-sm font-medium whitespace-nowrap">Gift Cards (0)</h3>
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
                        <div class="bg-bg-primary rounded-lg p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                    <span class="95 text-base-600 font-semibold">PlayStation</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="w-10 h-10 text-text-secondary">
                                            <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                        </svg>
                                        <span class="text-text-secondary text-base-600">Stacked</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 mt-5">
                                <span
                                    class="text-base-400" >
                                    Galaxy Skin – PSN / Xbox / PC Full Access
                                </span>
                                <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                                    alt="">
                            </div>
                            <div class="flex items-center justify-between mt-10">
                                <div class="">
                                    <span
                                        class="text-base-600 font-semibold" >
                                        PEN175.27
                                    </span>
                                </div>
                                <div class="flex
                                        items-center gap-2">
                                        <flux:icon name="clock" class="w-6 h-6 50" />
                                        <span class="text-xs-400 50">
                                            Instant
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-bg-primary rounded-lg p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                    <span class="text-[#4ADE80] text-base-400">Xbox</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-10 h-10 text-text-secondary">
                                        <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                    </svg>
                                    <span class="text-text-secondary text-base-600">Stacked</span>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <span
                                    class="text-base-400">
                                    Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                </span>
                                <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                    alt="">
                            </div>
                            <div class="flex items-center justify-between mt-10">
                                <div class="">
                                    <span
                                        class="text-base-600 font-semibold" >
                                        PEN175.27
                                    </span>
                                </div>
                                <div class="flex
                                        items-center gap-2">
                                        <flux:icon name="clock" class="w-6 h-6 50" />
                                        <span class="text-xs-400 50">
                                            Instant
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-bg-primary rounded-lg p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                    <span class="text-[#4ADE80] text-base-400">Xbox</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-10 h-10 text-text-secondary">
                                        <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                    </svg>
                                    <span class="text-text-secondary text-base-600">Stacked</span>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <span
                                    class="text-base-400">
                                    Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                </span>
                                <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                    alt="">
                            </div>
                            <div class="flex items-center justify-between mt-10">
                                <div class="">
                                    <span
                                        class="text-base-600 font-semibold" >
                                        PEN175.27
                                    </span>
                                </div>
                                <div class="flex
                                        items-center gap-2">
                                        <flux:icon name="clock" class="w-6 h-6 50" />
                                        <span class="text-xs-400 50">
                                            Instant
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-bg-primary rounded-lg p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                    <span class="text-[#4ADE80] text-base-400">Xbox</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-10 h-10 text-text-secondary">
                                        <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                    </svg>
                                    <span class="text-text-secondary text-base-600">Stacked</span>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <span
                                    class="text-base-400">
                                    Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                </span>
                                <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                    alt="">
                            </div>
                            <div class="flex items-center justify-between mt-10">
                                <div class="">
                                    <span
                                        class="text-base-600 font-semibold" >
                                        PEN175.27
                                    </span>
                                </div>
                                <div class="flex
                                        items-center gap-2">
                                        <flux:icon name="clock" class="w-6 h-6 50" />
                                        <span class="text-xs-400 50">
                                            Instant
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-bg-primary rounded-lg p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                    <span class="text-[#4ADE80] text-base-400">Xbox</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-10 h-10 text-text-secondary">
                                        <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                    </svg>
                                    <span class="text-text-secondary text-base-600">Stacked</span>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <span
                                    class="text-base-400">
                                    Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                </span>
                                <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                    alt="">
                            </div>
                            <div class="flex items-center justify-between mt-10">
                                <div class="">
                                    <span
                                        class="text-base-600 font-semibold" >
                                        PEN175.27
                                    </span>
                                </div>
                                <div class="flex
                                        items-center gap-2">
                                        <flux:icon name="clock" class="w-6 h-6 50" />
                                        <span class="text-xs-400 50">
                                            Instant
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-bg-primary rounded-lg p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                    <span class="text-[#4ADE80] text-base-400">Xbox</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-10 h-10 text-text-secondary">
                                        <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                    </svg>
                                    <span class="text-text-secondary text-base-600">Stacked</span>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <span
                                    class="text-base-400">
                                    Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                </span>
                                <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                    alt="">
                            </div>
                            <div class="flex items-center justify-between mt-10">
                                <div class="">
                                    <span
                                        class="text-base-600 font-semibold" >
                                        PEN175.27
                                    </span>
                                </div>
                                <div class="flex
                                        items-center gap-2">
                                        <flux:icon name="clock" class="w-6 h-6 50" />
                                        <span class="text-xs-400 50">
                                            Instant
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-bg-primary rounded-lg p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                    <span class="text-[#4ADE80] text-base-400">Xbox</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-10 h-10 text-text-secondary">
                                        <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                    </svg>
                                    <span class="text-text-secondary text-base-600">Stacked</span>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <span
                                    class="text-base-400">
                                    Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                </span>
                                <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                    alt="">
                            </div>
                            <div class="flex items-center justify-between mt-10">
                                <div class="">
                                    <span
                                        class="text-base-600 font-semibold" >
                                        PEN175.27
                                    </span>
                                </div>
                                <div class="flex
                                        items-center gap-2">
                                        <flux:icon name="clock" class="w-6 h-6 50" />
                                        <span class="text-xs-400 50">
                                            Instant
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-bg-primary rounded-lg p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                    <span class="text-[#4ADE80] text-base-400">Xbox</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-10 h-10 text-text-secondary">
                                        <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                    </svg>
                                    <span class="text-text-secondary text-base-600">Stacked</span>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <span
                                    class="text-base-400">
                                    Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                </span>
                                <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                    alt="">
                            </div>
                            <div class="flex items-center justify-between mt-10">
                                <div class="">
                                    <span
                                        class="text-base-600 font-semibold" >
                                        PEN175.27
                                    </span>
                                </div>
                                <div class="flex
                                        items-center gap-2">
                                        <flux:icon name="clock" class="w-6 h-6 50" />
                                        <span class="text-xs-400 50">
                                            Instant
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-bg-primary rounded-lg p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                    <span class="text-[#4ADE80] text-base-400">Xbox</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-10 h-10 text-text-secondary">
                                        <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                    </svg>
                                    <span class="text-text-secondary text-base-600">Stacked</span>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <span
                                    class="text-base-400">
                                    Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                </span>
                                <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                    alt="">
                            </div>
                            <div class="flex items-center justify-between mt-10">
                                <div class="">
                                    <span
                                        class="text-base-600 font-semibold ">
                                        PEN175.27
                                    </span>
                                </div>
                                <div class="flex
                                        items-center gap-2">
                                        <flux:icon name="clock" class="w-6 h-6 50" />
                                        <span class="text-xs-400 50">
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
                        <div class="w-md">
                            <x-ui.input type="text" placeholder="Search" class="w-full p-2 border-2 border-zinc-800" />
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
    @endif
    @if ($activeInnerMenu === 'reviews')
        <section class="container mx-auto bg-bg-primary p-10! rounded-2xl mb-10">
            <div class="">
                <h2 class="font-semibold text-3xl">Reviews</h2>
            </div>
            <div class="flex items-center gap-4 mt-5 mb-5">
                <div class="">
                    <button wire:navigate wire:click="switchReviewItem('all')"
                        class="{{ $reviewItem === 'all' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} font-semibold border-1 border-zinc-500 py-2 px-4 sm:py-3 sm:px-6 rounded-2xl">All</button>
                </div>
                <div class="">
                    <button wire:navigate wire:click="switchReviewItem('positive')"
                        class="{{ $reviewItem === 'positive' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} font-semibold border-1 border-zinc-500 py-2 px-4 sm:py-3 sm:px-6 rounded-2xl inline-block">
                        {!! $reviewItem === 'positive'
                            ? '<img src="' . asset('assets/images/user_profile/New Project.png') . '" alt="" class="inline-block">'
                            : '<img src="' . asset('assets/images/user_profile/thumb up filled.svg') . '" alt="" class="inline-block">' !!}

                        Positive
                    </button>
                </div>
                <div class="">
                    <button wire:navigate wire:click="switchReviewItem('negative')"
                        class="{{ $reviewItem === 'negative' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} border-1 border-zinc-500 font-semibold py-2 px-4 sm:py-3 sm:px-6 rounded-2xl inline-block">
                        <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt=""
                            class="inline-block">
                        Negative
                    </button>
                </div>
            </div>
            @if ($reviewItem === 'all')
                <div class="flex flex-col gap-5">
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                        alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-text-white self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Yeg***
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-text-white self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Did not respond in over 24 hours to the messages, even though "average delivery
                                    time" is
                                    3
                                    hours, and being online on Fortnite. Was friended for over 48 hours and did not send
                                    the
                                    gift nor reply to the messages.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-text-white self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Did not respond in over 24 hours to the messages, even though "average delivery
                                    time" is
                                    3
                                    hours, and being online on Fortnite. Was friended for over 48 hours and did not send
                                    the
                                    gift nor reply to the messages.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                        alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-text-white self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Yeg***
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                        alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-text-white self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Yeg***
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                        alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-text-white self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Yeg***
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-text-white self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Did not respond in over 24 hours to the messages, even though "average delivery
                                    time" is
                                    3
                                    hours, and being online on Fortnite. Was friended for over 48 hours and did not send
                                    the
                                    gift nor reply to the messages.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($reviewItem === 'positive')
                <div class="flex flex-col gap-5">
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                        alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-text-white self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Yeg***
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                        alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-text-white self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Yeg***
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                        alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-text-white self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Yeg***
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                        alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-text-white self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Yeg***
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                        alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-text-white self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Yeg***
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($reviewItem === 'negative')
                <div class="flex flex-col gap-5">
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-zinc-700 self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Did not respond in over 24 hours to the messages, even though "average delivery
                                    time" is
                                    3
                                    hours, and being online on Fortnite. Was friended for over 48 hours and did not send
                                    the
                                    gift nor reply to the messages.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-zinc-700 self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Did not respond in over 24 hours to the messages, even though "average delivery
                                    time" is
                                    3
                                    hours, and being online on Fortnite. Was friended for over 48 hours and did not send
                                    the
                                    gift nor reply to the messages.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt="">
                                    <p class="font-semibold text-2xl">Items</p>
                                    <span class="border-l border-zinc-700 self-stretch"></span>
                                    <p class="text-xs">Yeg***</p>
                                </div>
                                <div class="">
                                    <span>24.10.25</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                    Did not respond in over 24 hours to the messages, even though "average delivery
                                    time" is
                                    3
                                    hours, and being online on Fortnite. Was friended for over 48 hours and did not send
                                    the
                                    gift nor reply to the messages.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="pagination">
                <x-frontend.pagination-ui />
            </div>

        </section>
    @endif
    @if ($activeInnerMenu === 'about')
        <section class="container mx-auto bg-bg-primary rounded-2xl mb-10 p-5 sm:p-10 md:p-20">
            <div class="mb-5">
                <h2 class="font-semibold text-3xl">About</h2>
            </div>
            <div class="flex flex-col gap-5">
                <div class="p-6 bg-white/10 rounded-2xl">
                    <div class="flex items-center justify-between">
                        <div class="">
                            <h3 class="text-2xl font-semibold text-text-white">Description</h3>
                        </div>
                        <div class="">
                            <x-flux::icon name="pencil-square" class="w-5 h-5 inline-block" stroke="white" />
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="">
                            <p class="text-base text-text-white">
                                Hey there!
                            </p>
                        </div>
                        <div class="">
                            <p class="text-base text-text-white">
                                At PixelStoreLAT, we bring you the best digital deals, game keys, and in-game items —
                                fast, safe, and hassle-free. Trusted by thousands of gamers worldwide with 97% positive
                                reviews. Level up your experience with us today!
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white/10 rounded-2xl">
                    <div class="">
                        <p class="text-base text-text-white">
                            Registered: Feb 20, 2023
                        </p>
                    </div>
                </div>
            </div>
        </section>
    @endif
</main>
