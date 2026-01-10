<section class="mx-auto">
    <section class="relative z-0!">
        <div class="inner_banner h-16 sm:h-32">
            <img src="{{ asset('assets/images/user_profile/inner_banner.png') }}" alt="" class="w-full h-full">
        </div>
    </section>
    {{-- profile header --}}
    <section
        class="container p-4 sm:p-10 rounded-2xl -mt-5 sm:-mt-10 shadow-xl mb-12 relative z-20 bg-white dark:bg-bg-secondary isolate">
        <div class="">
            <div class="flex justify-between">
                <div class="flex items-center gap-6 sm:gap-10">
                    <div class="">
                        <div class="relative">
                            <div class="w-20 h-20 sm:w-40 sm:h-40">
                                <img src="{{ auth_storage_url($user?->avatar) }}" alt="{{ $user->name }}"
                                    class="h-full w-full rounded-full border-2 border-text-white" />
                            </div>
                            <div class="absolute -right-5 top-7 sm:-right-3 sm:top-20 w-10 h-10 sm:w-12 sm:h-12">
                                <img src="{{ asset('assets/images/user_profile/Frame 1261153813.png') }}" alt=""
                                    class="w-full h-full rounded-full">
                            </div>
                        </div>

                    </div>
                    <div class="">
                        <div class="flex gap-2 items-center mb-0 sm:mb-2">
                            <h3 class="text-base sm:text-2xl font-semibold text-text-white mb-2">{{ $user->full_name }}
                            </h3>
                            <x-phosphor name="seal-check" variant="solid" class="fill-zinc-700 w-5 h-5" />
                        </div>
                        <div class="flex items-center gap-2 mb-0 sm:mb-2">
                            <x-phosphor name="thumbs-up" variant="solid" class="fill-zinc-700 w-5 h-5" />
                            <span class="text-text-white font-normal text-xs">99.3%</span>
                            <span class="text-text-white font-normal text-xs">|</span>
                            <span class="text-text-white font-normal text-xs">2434 {{ __('Reviews') }}</span>
                        </div>
                        <div class="flex items-center">
                            @if ($user->isOnline())
                                <x-phosphor name="dot" variant="solid" class="fill-green w-10 h-10 p-0! m-0!" />
                                <span class="text-base-400 text-text-white">{{ __('Online') }}</span>
                            @else
                                <x-phosphor name="dot" variant="solid" class="fill-gray-400 w-10 h-10 p-0! m-0!" />
                                <span class="text-text-white font-normal text-xs">{{ $user->offlineStatus() }}</span>
                            @endif
                        </div>

                    </div>
                </div>
                @auth
                    <div class="icon">
                        <a href="{{ route('user.account-settings') }}" wire:navigate>
                            <x-flux::icon name="pencil-square" class="w-6 h-6 inline-block stroke-text-text-white"
                                stroke="currentColor" />
                        </a>
                    </div>
                @endauth

            </div>
            <div class="border-b border-zinc-700 mt-6 mb-4"></div>
            <div class="flex gap-6">
                <a wire:navigate href="{{ route('profile', ['username' => $user->username, 'tab' => 'shop']) }}"
                    class="group border-b-3
                 {{ request()->routeIs('profile') && (request('tab') === 'shop' || request('tab') === null) ? 'border-zinc-500' : 'border-transparent' }}">
                    <span class="relative z-10 text-text-white">
                        {{ __('Shop') }}
                    </span>
                </a>

                <a wire:navigate href="{{ route('profile', ['username' => $user->username, 'tab' => 'reviews']) }}"
                    class="group border-b-3
                 {{ request('tab') === 'reviews' ? 'border-zinc-500' : 'border-transparent' }}">
                    <span class="relative z-10 text-text-white">
                        {{ __('Reviews') }}
                    </span>
                </a>
                <a wire:navigate href="{{ route('profile', ['username' => $user->username, 'tab' => 'about']) }}"
                    class="group border-b-3
                 {{ request('tab') === 'about' ? 'border-zinc-500' : 'border-transparent' }}">
                    <span class="relative z-10 text-text-white">
                        {{ __('About') }}
                    </span>
                </a>
            </div>
        </div>
    </section>

</section>
