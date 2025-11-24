<div>
    <livewire:backend.user.profile.profile-component />
    <section class="container mx-auto mb-30">
        <div class="mb-6">
            <h3 class="text-4xl mb-4">{{ __('Shop') }}</h3>
            {{-- profile nav --}}
            <div class="flex gap-3 sm:gap-6 items-start">
                <button wire:navigate wire:click="switchTab('currency')" class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'currency' ? 'bg-zinc-500' : 'bg-zinc-800' }} b rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/Vector.png') }}" alt="Currency Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium whitespace-nowrap">{{ __('Currency (0)') }}</h3>
                </button>

                <button wire:navigate wire:click="switchTab('account')" class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'account' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download (4) 1.png') }}" alt="Account Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium whitespace-nowrap">{{ __('Account (0)') }}</h3>
                </button>

                <button wire:navigate wire:click="switchTab('items')" class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'items' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download 1.png') }}" alt="Items Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium whitespace-nowrap">{{ __('Items (0)') }}</h3>
                </button>

                <button wire:navigate wire:click="switchTab('topups')" class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'topups' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download (2) 1.png') }}" alt="Top Ups Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium whitespace-nowrap">{{ __('Top Ups (0)') }}</h3>
                </button>

                <button wire:navigate wire:click="switchTab('giftcards')" class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'giftcards' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download (1) 1.png') }}" alt="Gift Cards Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium whitespace-nowrap">{{ __('Gift Cards (0)') }}</h3>
                </button>
            </div>
            @if ($activeTab === 'currency')
                {{-- select game --}}
                <div class="w-full sm:w-sm md:w-md lg:w-md mt-6 border-2 border-zinc-800 rounded-lg">
                    <x-ui.select wire:model="country_id" id="country_id">
                        <option value="All Game">{{ __('All Game') }}</option>
                        <option value="All Game">{{ __('All Game') }}</option>
                        <option value="All Game">{{ __('All Game') }}</option>
                    </x-ui.select>
                </div>

                {{-- games --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-10">
                    <div class="bg-bg-primary rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="95 text-base-600 font-semibold">{{ __('PlayStation') }}</span>
                            </div>
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-10 h-10 text-text-secondary">
                                        <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                    </svg>
                                    <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mt-5">
                            <span class="text-base-400">
                                {{ __('Galaxy Skin – PSN / Xbox / PC Full Access') }}
                            </span>
                            <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold">
                                    {{ __('PEN175.27') }}
                                </span>
                            </div>
                            <div class="flex
                                        items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 50" />
                                <span class="text-xs-400 50">
                                    {{ __('Instant') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-bg-primary rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-text-secondary">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400">
                                {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold">
                                    {{ __('PEN175.27') }}
                                </span>
                            </div>
                            <div class="flex
                                        items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 50" />
                                <span class="text-xs-400 50">
                                    {{ __('Instant') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-bg-primary rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-text-secondary">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400">
                                {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold">
                                    {{ __('PEN175.27') }}
                                </span>
                            </div>
                            <div class="flex
                                        items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 50" />
                                <span class="text-xs-400 50">
                                    {{ __('Instant') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-bg-primary rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-text-secondary">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400">
                                {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold">
                                    {{ __('PEN175.27') }}
                                </span>
                            </div>
                            <div class="flex
                                        items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 50" />
                                <span class="text-xs-400 50">
                                    {{ __('Instant') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-bg-primary rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-text-secondary">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400">
                                {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold">
                                    {{ __('PEN175.27') }}
                                </span>
                            </div>
                            <div class="flex
                                        items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 50" />
                                <span class="text-xs-400 50">
                                    {{ __('Instant') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-bg-primary rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-text-secondary">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400">
                                {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold">
                                    {{ __(' PEN175.27') }}
                                </span>
                            </div>
                            <div class="flex
                                        items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 50" />
                                <span class="text-xs-400 50">
                                    {{ __('Instant') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-bg-primary rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-text-secondary">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400">
                                {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold">
                                    {{ __('PEN175.27') }}
                                </span>
                            </div>
                            <div class="flex
                                        items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 50" />
                                <span class="text-xs-400 50">
                                    {{ __('Instant') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-bg-primary rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-text-secondary">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400">
                                {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold">
                                    {{ __('PEN175.27') }}
                                </span>
                            </div>
                            <div class="flex
                                        items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 50" />
                                <span class="text-xs-400 50">
                                    {{ __('Instant') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-bg-primary rounded-lg p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                                <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-text-secondary">
                                    <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                                </svg>
                                <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <span class="text-base-400">
                                {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                            </span>
                            <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                                alt="">
                        </div>
                        <div class="flex items-center justify-between mt-10">
                            <div class="">
                                <span class="text-base-600 font-semibold ">
                                    {{ __('PEN175.27') }}
                                </span>
                            </div>
                            <div class="flex
                                        items-center gap-2">
                                <flux:icon name="clock" class="w-6 h-6 50" />
                                <span class="text-xs-400 50">
                                    {{ __('Instant') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- account --}}

            @if ($activeTab === 'account')
                <div class="mt-6 flex items-center gap-4">
                    <div class="w-md">
                        <x-ui.input type="text" placeholder="Search"
                            class="w-full p-2 border-2 border-zinc-800" />
                    </div>
                    <div class="w-md border-2 border-zinc-800 rounded-lg">
                        <x-ui.select wire:model="game_id" id="game_id">
                            <option value="">{{ __('All Game') }}</option>
                            <option value="All Game">{{ __('All Game') }}</option>
                        </x-ui.select>
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
                        <x-ui.input type="text" placeholder="Search"
                            class="w-full p-2 border-2 border-zinc-800" />
                    </div>
                    <div class="w-md border-2 border-zinc-800 rounded-lg">
                        <x-ui.select wire:model="game_id" id="game_id">
                            <option value="">{{ __('All Game') }}</option>
                            <option value="All Game">{{ __('All Game') }}</option>
                        </x-ui.select>
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
                    <div class="w-full sm:w-sm md:w-md lg:w-md mt-6 border-2 border-zinc-800 rounded-lg">
                        <x-ui.select wire:model="game_id" id="game_id">
                            <option value="">{{ __('All Game') }}</option>
                            <option value="All Game">{{ __('All Game') }}</option>
                        </x-ui.select>
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
                    <div class="w-full sm:w-sm md:w-md lg:w-md mt-6 border-2 border-zinc-800 rounded-lg">
                        <x-ui.select wire:model="game_id" id="game_id">
                            <option value="">{{ __('All Game') }}</option>
                            <option value="All Game">{{ __('All Game') }}</option>
                        </x-ui.select>
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
</div>
