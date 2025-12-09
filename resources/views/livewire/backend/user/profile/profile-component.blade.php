<section class=" mx-auto">
    <section class="relative z-0">
        <div class="inner_banner h-16 sm:h-32">
            <img src="{{ asset('assets/images/user_profile/inner_banner.png') }}" alt="" class="w-full h-full">
        </div>
    </section>
    {{-- profile header --}}
    <section
        class="relative z-20 container mx-auto bg-bg-secondary p-4 sm:p-10 rounded-2xl -mt-5 sm:-mt-10  shadow-xl mb-12">
        <div class="relative z-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-6 sm:gap-10">
                    <div class="">
                        <div class="relative">
                            <div class="w-20 h-20 sm:w-40 sm:h-40">
                                <img src="{{ auth_storage_url($user->avatar) }}" alt=""
                                    class="h-full w-full rounded-full border-2 border-text-white">
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
                            <x-phosphor name="dot" variant="solid" class="fill-green w-10 h-10 p-0! m-0!" />
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
            </div>
        </div>
    </section>
    {{-- <section
        class="container mx-auto bg-bg-secondary p-4 sm:p-10 rounded-2xl absolute left-1/2 -translate-x-1/2 top-10 sm:top-5 md:top-15">
        <div class="flex justify-between">
            <div class="flex items-center gap-6 sm:gap-10">
                <div class="">
                    <div class="relative">
                        <div class="w-20 h-20 sm:w-40 sm:h-40">
                            <img src="{{ auth_storage_url($user->avatar) }}" alt=""
                                class="h-full w-full rounded-full border-2 border-text-white">
                        </div>
                        <div class="absolute -right-5 top-7 sm:-right-3 sm:top-20 w-10 h-10 sm:w-12 sm:h-12">
                            <img src="{{ asset('assets/images/user_profile/Frame 1261153813.png') }}" alt=""
                                class="w-full h-full rounded-full">
                        </div>
                    </div>

                </div>
                <div class="">
                    <div class="flex gap-2 items-center mb-0 sm:mb-2">
                        <h3 class="text-base sm:text-2xl font-semibold text-text-white mb-2">{{ $user->full_name }}</h3>
                        <x-phosphor name="seal-check" variant="solid" class="fill-zinc-700 w-5 h-5" />
                    </div>
                    <div class="flex items-center gap-2 mb-0 sm:mb-2">
                        <x-phosphor name="thumbs-up" variant="solid" class="fill-zinc-700 w-5 h-5" />
                        <span class="text-text-white font-normal text-xs">99.3%</span>
                        <span class="text-text-white font-normal text-xs">|</span>
                        <span class="text-text-white font-normal text-xs">2434 {{ __('Reviews') }}</span>
                    </div>
                    <div class="flex items-center">
                        <x-phosphor name="dot" variant="solid" class="fill-green w-10 h-10 p-0! m-0!" />
                        <span class="text-base-400 text-text-white">{{ __('Online') }}</span>
                    </div>
                </div>

                <!-- Stats -->
                <div class="flex flex-col gap-2">


                    <div class="text-white space-y-2">

                        <!-- Username + Verified Badge -->
                        <div class="flex items-center gap-2">
                            <h3 class="text-2xl font-semibold">
                                {{ $user->username }}
                            </h3>

                            <!-- Purple verification badge -->
                            <div class="w-5 h-5 rounded-full bg-zinc-500  flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24"
                                    class="w-3 h-3">
                                    <path d="M10 15.172 6.828 12l-1.414 1.414L10 18 20 8l-1.414-1.414z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Rating row -->
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#6d28d9" viewBox="0 0 24 24" class="w-5 h-5">
                                <path
                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z">
                                </path>
                            </svg>

                            <p class="text-sm text-gray-100">99.3% | 2434 reviews</p>
                        </div>

                        <!-- Online Status -->
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#12D212" viewBox="0 0 24 24" class="w-5 h-5">
                                <circle cx="12" cy="12" r="6"></circle>
                            </svg>

                            <span class="text-sm text-white">Online</span>
                        </div>

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
    </section> --}}
    {{-- about --}}
    {{-- <div class="min-h-10"></div> --}}
</section>
