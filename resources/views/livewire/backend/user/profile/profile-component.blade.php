<section class=" mx-auto relative">
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
                            <img src="{{ auth_storage_url($user->avatar) }}" alt="" class="h-full w-full">
                        </div>
                        <div class="absolute -right-5 top-7 sm:-right-3 sm:top-20 w-10 h-10 sm:w-15 sm:h-15">
                            {{-- <img src="{{ asset('assets/images/user_profile/Frame 1261153813.png') }}" alt=""
                                class="w-full h-full"> --}}
                        </div>
                    </div>

                </div>
                <div class="">
                    <h3 class="text-4xl font-semibold text-text-white mb-2">{{ $user->username }}</h3>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#12D212"
                            class="w-10 h-10 text-text-secondary">
                            <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                        </svg>
                        <span class="text-base-400 text-text-white">{{ __('Online') }}</span>
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
    </section>
    {{-- about --}}
    <div class="min-h-70"></div>
</section>
