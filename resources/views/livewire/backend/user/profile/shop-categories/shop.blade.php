<div>
    <livewire:backend.user.profile.profile-component />
    <section class="container mx-auto mb-30">
        <div class="mb-6">
            <h3 class="text-4xl mb-4">{{ __('Shop') }}</h3>
            {{-- profile nav --}}
            <div class="flex gap-3 sm:gap-6 items-start">
                <a wire:navigate
                    href="{{ route('profile.index', ['username' => request('username'), 'activeTab' => 'currency']) }}"
                    class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'currency' ? 'bg-zinc-500' : 'bg-zinc-800' }} b rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/Vector.png') }}" alt="Currency Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium whitespace-nowrap">{{ __('Currency (0)') }}</h3>
                </a>

                <a wire:navigate
                    href="{{ route('profile.index', ['username' => request('username'), 'activeTab' => 'account']) }}"
                    class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'account' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download (4) 1.png') }}" alt="Account Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium whitespace-nowrap">{{ __('Account (0)') }}</h3>
                </a>

                <a wire:navigate
                    href="{{ route('profile.index', ['username' => request('username'), 'activeTab' => 'items']) }}"
                    class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'items' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download 1.png') }}" alt="Items Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium whitespace-nowrap">{{ __('Items (0)') }}</h3>
                </a>

                <a wire:navigate
                    href="{{ route('profile.index', ['username' => request('username'), 'activeTab' => 'topups']) }}"
                    class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'topups' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download (2) 1.png') }}" alt="Top Ups Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium whitespace-nowrap">{{ __('Top Ups (0)') }}</h3>
                </a>

                <a wire:navigate
                    href="{{ route('profile.index', ['username' => request('username'), 'activeTab' => 'giftcards']) }}"
                    class="flex flex-col items-center">
                    <div
                        class="w-[50px] h-[50px] sm:w-[60px] sm:h-[60px] mb-2 {{ $activeTab === 'giftcards' ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download (1) 1.png') }}" alt="Gift Cards Icon"
                            class="w-[25px] h-[25px] sm:w-[30px] sm:h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium whitespace-nowrap">{{ __('Gift Cards (0)') }}</h3>
                </a>
            </div>
            @if (in_array($activeTab, ['currency', 'account', 'items', 'topups', 'giftcards']))
                <livewire:backend.user.profile.profile-category-items />
            @endif
        </div>
    </section>
</div>
