<header x-data="{ mobileMenuOpen: false, notification: false, dropdown: '', globalSearchModal: false, open: '' }" x-cloak
    class="sticky top-0 z-50  {{ request()->routeIs('home') ? 'bg-linear-to-r from-zinc-950/50 via-text-text-white to-zinc-950/50 glass-card shadow-none!' : 'glass-card' }}">
    <div class="{{ request()->routeIs('user.*') ? '' : '2xl:container-wide container' }} px-4 py-4 flex items-center justify-between relative"
        x-cloak>
        <div class=""><a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/header_logo.png') }}" alt=""></a>
        </div>
        @include('partials.user-navigation')

        {{-- Main Navigation Icons --}}
        <div class="flex  items-center">
            @auth
                <button class="p-1 rounded-full bg-transparent hover:bg-zinc-500/20 transition-colors">
                    <flux:icon name="chat-bubble-oval-left" class="w-6 h-6 text-text-text-white" />
                </button>

                <button class="px-1 py-0.5 mt-1 rounded-full bg-transparent hover:bg-zinc-500/20 transition-colors"
                    @click="notification = !notification">
                    <div class="relative inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 stroke-text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="white">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span
                            class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-pink-500 text-[10px] text-white">1</span>
                    </div>
                </button>
            @endauth

            <div class="px-1 hidden sm:flex">
                <x-language />
            </div>

            <div class="flex items-center" x-data>
                @auth
                    @include('partials.profile-dropdown')
                @else
                    <div class="mr-8">
                        <a href="{{ route('login') }}">
                            <flux:icon name="user-circle" class="w-7 h-7 text-text-text-white " />
                        </a>
                    </div>
                @endauth

                <!-- Light/Dark Mode Toggle -->
                <button type="button" @click="$flux.dark = false" :aria-pressed="!$flux.dark"
                    class="flex items-center justify-center w-10 h-8 text-lg rounded-l-full transition-colors duration-200 hidden md:flex"
                    :class="!$flux.dark ? 'bg-zinc-400 text-text-white' : 'bg-transparent text-zinc-600 dark:text-zinc-300'">
                    <flux:icon name="sun" class="w-5 h-5 stroke-white" />
                </button>

                <button type="button" @click="$flux.dark = true" :aria-pressed="$flux.dark"
                    class="flex items-center justify-center w-10 h-8 text-lg rounded-r-full transition-colors duration-200 hidden md:flex"
                    :class="$flux.dark ? 'bg-zinc-400 text-text-white' : 'bg-transparent text-zinc-600 dark:text-zinc-300'">
                    <flux:icon name="moon" class="w-5 h-5 stroke-current" />
                </button>

                <div x-show="$flux.dark" class="md:hidden">
                    <flux:icon name="moon" class="w-5 h-5 stroke-current" @click="$flux.dark = false" />
                </div>
                <div x-show="!$flux.dark" class="md:hidden">
                    <flux:icon name="sun" class="w-5 h-5 stroke-current" @click="$flux.dark = true" />
                </div>
            </div>

            {{-- Mobile menu button --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="xl:hidden ml-2 inline-flex items-center justify-center p-2 rounded-md text-text-secondary hover:text-text-text-white hover:bg-bg-secondary focus:outline-none focus:ring-2 focus:ring-inset focus:ring-text-text-text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>
    {{-- Mobile sidebar --}}
    <div x-show="mobileMenuOpen" x-cloak @click.outside="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-100"
        class="absolute top-18 right-0 w-3/4 max-w-[380px] bg-bg-primary backdrop:blure-md z-100 rounded-lg transition-all duration-300 h-auto p-4 shadow-lg overflow-y-auto ">
        <div class="flex justify-between items-center bg-bg-secondary p-2 rounded-lg mb-2">
            <h2 class="text-lg font-semibold">Category</h2>
            <button @click="mobileMenuOpen = false">
                <flux:icon name="x-mark" class="w-5 h-5 stroke-current hover:stroke-pink-600" />
            </button>
        </div>

        @include('partials.mobile-user-navigation')
    </div>
    {{-- Notification --}}
    <div x-show="notification" x-cloak @click.outside="notification = false"
        y-transition:enter="transition ease-out duration-100"
        class="absolute top-20 right-2 w-[90%] xs:w-3/4 md:max-w-[600px] bg-bg-primary rounded-2xl! backdrop:blure-md z-100   transition-all duration-300 max-h-[65vh] text-text-text-white shadow-lg overflow-y-auto">
        <div class="pb-10 px-6">
            <!-- Header -->
            <div class="flex justify-between items-center p-4 pb-0">
                <h2 class="text-lg font-semibold">Notifications</h2>
                <button @click="notification = false"
                    class="absolute top-3 right-3 text-text-secondary hover:text-gray-600">
                    <flux:icon name="x-mark" class="w-5 h-5 stroke-current hover:stroke-pink-600" />
                </button>
            </div>
            <div class="mb-5 border-b border-zinc-600">
                <a href="javascript:void(0)" class="text-sm text-pink-500 hover:text-text-hover ps-4 pb-2">
                    Mark all as read
                </a>
            </div>

            <!-- Notification List -->
            <div class="space-y-4 h-full w-full  overflow-y-auto ">
                @for ($i = 0; $i < 3; $i++)
                    <div class="flex gap-2 md:gap-4 hover:bg-bg-hover rounded-xl p-4">
                        <div>
                            {{-- Notification icon --}}
                            <div
                                class="w-8 h-8 bg-zinc-200 dark:bg-zinc-300/10 rounded-full flex items-center justify-center mb-2">
                                <flux:icon name="bell" class="w-4 h-4 stroke-zinc-500" />
                            </div>
                        </div>
                        <div class="w-full">
                            <h3 class="font-semibold text-sm">Digimon Super Rumble is HERE!</h3>
                            <p class="text-sm text-text-secondary/80 mt-1">
                                Hello dear sellers, just now we've added Digimon Super Rumble game to Accounts and
                                Currency
                                categories.
                                You can start listing your offers any minute now.
                            </p>
                        </div>
                        <div class="w-20">
                            <span class="text-xs text-pink-500">9m ago</span>
                        </div>
                    </div>
                @endfor
                <div class="w-full text-center mt-2">
                    <x-ui.button href="{{ route('user.notifications') }}" class="w-80! py-2! block! mx-auto!">
                        {{ __('View all') }}
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>


    {{-- Dropdown --}}
    <livewire:frontend.partials.header-dropdown />

    {{-- Global Search Modal --}}
    <livewire:frontend.partials.search-modal>
</header>
