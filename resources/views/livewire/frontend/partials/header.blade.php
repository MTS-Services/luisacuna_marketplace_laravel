<header x-data="{ mobileMenuOpen: false, notification: false, dropdown: '', globalSearchModal: false, open: '' }" x-cloak
    class="sticky top-0 z-50  {{ request()->routeIs('home') ? 'bg-linear-to-r from-zinc-950/50 via-text-text-white to-zinc-950/50 glass-card shadow-none!' : 'glass-card' }}">
    <div class=" px-4 py-4 flex items-center justify-between relative" x-cloak>
        <div class="flex flex-row-reverse items-center justify-center">
            <div class="hidden xxs:flex ml-4 lg:ml-0 scale-75 xl:scale-100">
                <a href="{{ route('home') }}" wire:navigate>
                    <img src="{{ asset('assets/images/header_logo.png') }}" alt="{{ __('Logo') }}"></a>
            </div>
            {{-- Mobile menu button --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="xl:hidden  bg-bg-light-black inline-flex items-center justify-center p-2 rounded-md text-text-secondary hover:text-text-text-white hover:bg-bg-secondary focus:outline-none focus:ring-2 focus:ring-inset focus:ring-text-text-text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        @include('partials.user-navigation')

        {{-- Main Navigation Icons --}}
        <div class="flex gap-1  xl:gap-2 items-center">

            @guest
                <div class="xl:flex">
                    <x-language />
                </div>
            @endguest

            @auth
                <div class="hidden md:flex">
                    <x-language />
                </div>
            @endauth

            @auth
                <div class="flex items-center justify-center gap-1">
                    <a href="{{ route('user.messages') }}" wire:navigate
                        class=" rounded-full bg-transparent  transition-colors">
                        <flux:icon name="chat-bubble-oval-left" class="w-6 h-6 text-text-text-white" />
                    </a>
                    <button class="py-0.5 mt-1 rounded-full bg-transparent transition-colors"
                        @click="notification = !notification">
                        <div class="relative inline-flex">
                            <x-phosphor-bell class="w-6 h-6 text-text-primary" />

                            <span
                                class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-pink-500 text-[10px] text-white">
                                1
                            </span>
                        </div>
                    </button>
                </div>

            @endauth

            <div class="flex items-center" x-data>

                @guest
                    <div class="flex bg-zinc-200 dark:bg-zinc-800 lg:p-1 rounded-full">
                        <!-- Light/Dark Mode Toggle -->
                        <button type="button" @click="$flux.dark = false" :aria-pressed="!$flux.dark"
                            class="flex items-center justify-center w-8 h-6 text-lg rounded-l-full transition-colors duration-200 xl:flex"
                            :class="!$flux.dark ? 'bg-zinc-400 text-text-white' :
                                'bg-transparent text-zinc-600 dark:text-zinc-300'">
                            <flux:icon name="sun" class="w-5 h-5 stroke-white" />
                        </button>

                        <button type="button" @click="$flux.dark = true" :aria-pressed="$flux.dark"
                            class="flex items-center justify-center w-8 h-6 text-lg rounded-r-full transition-colors duration-200 xl:flex"
                            :class="$flux.dark ? 'bg-zinc-400 text-text-white' :
                                'bg-transparent text-zinc-600 dark:text-zinc-300'">
                            <flux:icon name="moon" class="w-5 h-5 stroke-current" />
                        </button>

                        {{-- <div x-show="$flux.dark" class="lg:hidden">
                        <flux:icon name="moon" class="w-5 h-5 stroke-current" @click="$flux.dark = false" />
                    </div>
                    <div x-show="!$flux.dark" class="lg:hidden">
                        <flux:icon name="sun" class="w-5 h-5 stroke-current" @click="$flux.dark = true" />
                    </div> --}}
                    </div>
                @endguest



                @auth
                    <div class="hidden md:flex bg-zinc-200 dark:bg-zinc-800 lg:p-1 rounded-full">
                        <!-- Light/Dark Mode Toggle -->
                        <button type="button" @click="$flux.dark = false" :aria-pressed="!$flux.dark"
                            class="flex items-center justify-center w-8 h-6 text-lg rounded-l-full transition-colors duration-200 xl:flex"
                            :class="!$flux.dark ? 'bg-zinc-400 text-text-white' :
                                'bg-transparent text-zinc-600 dark:text-zinc-300'">
                            <flux:icon name="sun" class="w-5 h-5 stroke-white" />
                        </button>

                        <button type="button" @click="$flux.dark = true" :aria-pressed="$flux.dark"
                            class="flex items-center justify-center w-8 h-6 text-lg rounded-r-full transition-colors duration-200 xl:flex"
                            :class="$flux.dark ? 'bg-zinc-400 text-text-white' :
                                'bg-transparent text-zinc-600 dark:text-zinc-300'">
                            <flux:icon name="moon" class="w-5 h-5 stroke-current" />
                        </button>

                        {{-- <div x-show="$flux.dark" class="lg:hidden">
                        <flux:icon name="moon" class="w-5 h-5 stroke-current" @click="$flux.dark = false" />
                    </div>
                    <div x-show="!$flux.dark" class="lg:hidden">
                        <flux:icon name="sun" class="w-5 h-5 stroke-current" @click="$flux.dark = true" />
                    </div> --}}
                    </div>
                @endauth

                @auth
                    @include('partials.profile-dropdown')
                @else
                    <div class="ml-3 flex">
                        <a href="{{ route('login') }}"
                            class="bg-zinc-500 hover:bg-zinc-50 transition-colors duration-300 hover:text-zinc-500 px-3 py-[3px] text-sm xl:text-base xl:py-[5px] text-white rounded-full">
                            {{-- <flux:icon name="user-circle" class="w-7 h-7 text-text-text-white " /> --}}
                            {{ __('Log in') }}
                        </a>

                    </div>
                @endauth
            </div>


        </div>
    </div>
    {{-- Mobile sidebar --}}
    <div x-show="mobileMenuOpen" x-cloak @click.outside="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-100"
        class="absolute top-18 right-0 w-full h-screen bg-bg-primary backdrop:blure-md z-100 rounded-lg transition-all duration-300  p-4 shadow-lg overflow-y-auto ">
        <div class="flex justify-between items-center bg-bg-hover p-2 rounded-lg mb-2">
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
        class="absolute top-18 right-3 w-[90%] xs:w-3/4 md:max-w-[600px] dark:bg-zinc-800 bg-white rounded-2xl! backdrop:blure-md z-100   transition-all duration-300 max-h-[65vh] text-text-text-white shadow-lg overflow-y-auto">
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
    {{-- <livewire:frontend.partials.search-modal> --}}
</header>
