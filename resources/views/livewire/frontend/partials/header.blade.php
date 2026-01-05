<header x-data="{ mobileMenuOpen: false, notification: false, dropdown: '', globalSearchModal: false, open: '' }" x-cloak
    class="sticky top-0 z-50   {{ request()->routeIs('home') ? 'bg-bg-secondary glass-card shadow-none!' : 'bg-bg-secondary glass-card' }}">
    <div class=" px-4 py-4 flex items-center justify-between relative" x-cloak>

        <div class="flex flex-row-reverse items-center justify-center">
            <div class="hidden xxs:flex  lg:ml-0 scale-75 xl:scale-100">
                <a href="{{ route('home') }}" wire:navigate
                    class="inline-block inline-flex gap-1 items-center justify-center">

                    {{-- <img src="{{ asset('assets/images/header_logo.png') }}" alt="{{ __('Logo') }}"></a> --}}
                    <x-cloudinary::image public-id="{{ app_logo() }}" removeBackground crop="scale" sizes="100vw"
                       class="rounded w-8 h-6" alt="{{ site_name() }}" />
                    <p>
                        {{ short_name() }}
                    </p>
                </a>
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
                    <x-language :currencies="$currencies" />
                </div>
            @endguest

            @auth
                <div class="hidden md:flex">
                    <x-language :currencies="$currencies" />
                </div>
            @endauth

            @auth('web')
                <div class="flex items-center justify-center gap-1">
                    {{-- <a href="{{ route('user.messages') }}" wire:navigate
                        class="">
                        <flux:icon name="chat-bubble-oval-left" class="w-6 h-6 text-text-text-white" />
                    </a> --}}
                    <button class="py-0.5 mt-1 rounded-full bg-transparent transition-colors"
                        @click="$dispatch('user-message-notification-show')">
                        <div class="relative inline-flex">
                            <flux:icon name="chat-bubble-oval-left" class="w-6 h-6 text-text-text-white" />
                            @if ($unreadMessageCount > 0)
                                <span
                                    class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-pink-500 text-[10px] text-white">
                                    {{ $unreadMessageCount }}
                                </span>
                            @endif
                        </div>
                    </button>

                    <button class="py-0.5 mt-1 rounded-full bg-transparent transition-colors"
                        @click="$dispatch('user-notification-show')">
                        <div class="relative inline-flex">
                            <flux:icon name="bell" class="w-6 h-6" />

                            @if ($unreadNotificationCount > 0)
                                <span
                                    class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-pink-500 text-[10px] text-white">
                                    {{ $unreadNotificationCount }}
                                </span>
                            @endif
                        </div>
                    </button>
                </div>

                <livewire:backend.user.messages.message-notificaiton-sidebar />

                <livewire:backend.user.notifications.notification-sidebar />
            @endauth

            <div class="flex items-center" x-data>

                @guest
                    <div class="flex
                    {{-- bg-zinc-200 dark:bg-zinc-800 --}}
                     lg:p-1 rounded-full">
                        {{-- <!-- Light/Dark Mode Toggle -->
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
                        </button> --}}


                        <button type="button" @click="$flux.dark = !$flux.dark" :aria-pressed="$flux.dark"
                            class="flex items-center justify-center w-9 h-9 rounded-full
           transition-all duration-300
           {{-- bg-zinc-200 dark:bg-zinc-700 --}}
           text-zinc-700 dark:text-zinc-200">

                            <!-- Sun -->
                            <flux:icon x-show="!$flux.dark" name="sun"
                                class="w-5 h-5 transition-transform duration-300" />

                            <!-- Half Moon -->
                            <flux:icon x-show="$flux.dark" name="moon"
                                class="w-5 h-5 transition-transform duration-300" />
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
                    <div
                        class="hidden md:flex
                    {{-- bg-zinc-200 dark:bg-zinc-800 --}}
                     lg:p-1 rounded-full">
                        <!-- Light/Dark Mode Toggle -->
                        {{-- <button type="button" @click="$flux.dark = false" :aria-pressed="!$flux.dark"
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
                        </button> --}}


                        <button type="button" @click="$flux.dark = !$flux.dark" :aria-pressed="$flux.dark"
                            class="flex items-center justify-center w-9 h-9 rounded-full
           transition-all duration-300
           {{-- bg-zinc-200 dark:bg-zinc-700 --}}
           text-zinc-700 dark:text-zinc-200">

                            <!-- Sun -->
                            <flux:icon x-show="!$flux.dark" name="sun"
                                class="w-5 h-5 transition-transform duration-300" />

                            <!-- Half Moon -->
                            <flux:icon x-show="$flux.dark" name="moon"
                                class="w-5 h-5 transition-transform duration-300" />
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
        class="absolute  top-18 right-0 w-full h-screen bg-bg-primary dark:bg-bg-secondary backdrop:blure-md z-100  md:rounded-lg transition-all duration-300  p-4 shadow-lg overflow-y-auto ">
        <div class="flex justify-between items-center bg-bg-hover p-2 rounded-lg mb-2">
            <h2 class="text-lg font-semibold">Category</h2>
            <button @click="mobileMenuOpen = false">
                <flux:icon name="x-mark" class="w-5 h-5 stroke-current hover:stroke-pink-600" />
            </button>
        </div>

        @include('partials.mobile-user-navigation')
    </div>
    {{-- Notification --}}



    {{-- Dropdown --}}
    <livewire:frontend.partials.header-dropdown />

    {{-- Global Search Modal --}}
    {{-- <livewire:frontend.partials.search-modal> --}}
</header>
