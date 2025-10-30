<header x-data="{ mobileMenuOpen: false, notification: false, dropdown: '' }"
    class="sticky top-0 z-50 {{ request()->routeIs('home') ? 'bg-gradient-to-r from-purple-950/50 via-text-white to-purple-950/50 glass-card shadow-none!' : 'glass-card' }}">
    <div class="container px-4 py-4 flex items-center justify-between relative">
        <div class=""><a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/header_logo.png') }}" alt=""></a>
        </div>

        @include('partials.user-navigation')

        <div class="flex items-center gap-2">
            <button class="btn btn-ghost btn-circle hover:bg-purple-500/20">
                {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                    <path
                        d="M181.66,106.34a8,8,0,0,1,0,11.32l-32,32a8,8,0,0,1-11.32,0L112,123.31,85.66,149.66a8,8,0,0,1-11.32-11.32l32-32a8,8,0,0,1,11.32,0L144,132.69l26.34-26.35A8,8,0,0,1,181.66,106.34ZM232,128A104,104,0,0,1,79.12,219.82L45.07,231.17a16,16,0,0,1-20.24-20.24l11.35-34.05A104,104,0,1,1,232,128Zm-16,0A88,88,0,1,0,51.81,172.06a8,8,0,0,1,.66,6.54L40,216,77.4,203.52a8,8,0,0,1,6.54.67A88,88,0,0,0,216,128Z">
                    </path>
                </svg> --}}
            </button>
            {{-- Notification --}}
            <button class="btn btn-ghost btn-circle hover:bg-purple-500/20" @click="notification = !notification">
                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 stroke-text-primary" fill="none"
                        viewBox="0 0 24 24" stroke="white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="badge badge-xs badge-primary indicator-item">1</span>
                </div>
            </button>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="Tailwind CSS Navbar component"
                            src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                    </div>
                </div>
                <ul tabindex="-1"
                    class="menu menu-sm dropdown-content bg-purple-600 rounded-box z-1 mt-3 w-52 p-2 shadow">
                    @auth
                        @if (auth()->guard('web')->check())
                            <li><a href="{{ route('profile') }}" class="text-white" wire:navigate>Profile</a></li>
                        @else
                            <li><a href="{{ route('admin.dashboard') }}" class="text-white" wire:navigate>Dashboard</a></li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-white" wire:navigate>Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-white" wire:navigate>Register</a></li>
                    @endauth
                    {{-- <li><a href="#" class="text-white">Settings</a></li> --}}
                </ul>
            </div>

            {{-- <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                <flux:radio value="light" icon="sun" />
                <flux:radio value="dark" icon="moon" />
            </flux:radio.group> --}}

            <div class="flex items-center" x-data>
                <!-- Light Mode Button -->
                <button type="button" x-on:click="$flux.dark = false"
                    class="flex items-center justify-center w-10 h-8 text-lg rounded-l-full transition-colors duration-200"
                    :class="!$flux.dark ?
                        'bg-zinc-400 text-white' :
                        'bg-transparent text-zinc-600 dark:text-zinc-300'">
                    <flux:icon name="sun" class="w-5 h-5 stroke-white" />
                </button>

                <!-- Dark Mode Button -->
                <button type="button" x-on:click="$flux.dark = true"
                    class="flex items-center justify-center w-10 h-8 text-lg rounded-r-full transition-colors duration-200"
                    :class="$flux.dark ?
                        'bg-zinc-400 text-white' :
                        'bg-transparent text-zinc-600 dark:text-zinc-300'">
                    <flux:icon name="moon" class="w-5 h-5 stroke-current" />
                </button>
            </div>

            {{-- <flux:ui-icon name="lucide:bell" class="text-blue-600" />
            <flux:ui-icon name="heroicon:user" class="text-gray-600" /> --}}


            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-text-white hover:bg-bg-secondary focus:outline-none focus:ring-2 focus:ring-inset focus:ring-text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- Dropdown --}}
        <section x-show="dropdown" x-cloak @click.outside="dropdown = false"
            class="absolute top-18 left-2 h-[calc(100vh-10rem)] overflow-y-auto mt-6">
            <div
                class="bg-bg-primary flex flex-col lg:flex-row items-center justify-between rounded-lg py-11 px-4 lg:px-10">
                <div class="pt-10 order-2 lg:order-1">
                    <h3 class="text-text-white text-base font-semibold pt-2 mb-6">Popular games</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2.5">
                        <div class="flex items-center gap-2.5 p-2.5">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/game_icon/Frame 100.png') }}" alt=""
                                    class="w-full h-full">
                            </div>
                            <p class="text-base font-normal text-text-white">New World Coins</p>
                        </div>
                        <div class="flex items-center gap-2.5 p-2.5 ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/game_icon/Frame 94.png') }}" alt=""
                                    class="w-full h-full">
                            </div>
                            <p class="text-base font-normal text-text-white">Worldforge Legends</p>
                        </div>
                        <div class="flex items-center gap-2.5 p-2.5 ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/game_icon/Frame 93.png') }}" alt=""
                                    class="w-full h-full">
                            </div>
                            <p class="text-base font-normal text-text-white">Exilecon Official Trailer</p>
                        </div>
                        <div class="flex items-center gap-2.5 p-2.5 ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/game_icon/Frame 96.png') }}" alt=""
                                    class="w-full h-full">
                            </div>
                            <p class="text-base font-normal text-text-white">Echoes of the Terra</p>
                        </div>
                        <div class="flex items-center gap-2.5 p-2.5 ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/game_icon/Frame 103.png') }}" alt=""
                                    class="w-full h-full">
                            </div>
                            <p class="text-base font-normal text-text-white">Path of Exile 2 Currency</p>
                        </div>
                        <div class="flex items-center gap-2.5 p-2.5 ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/game_icon/Frame 102.png') }}" alt=""
                                    class="w-full h-full">
                            </div>
                            <p class="text-base font-normal text-text-white">Epochs of Gaia</p>
                        </div>
                        <div class="flex items-center gap-2.5 p-2.5 ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/game_icon/Frame 105.png') }}" alt=""
                                    class="w-full h-full">
                            </div>
                            <p class="text-base font-normal text-text-white">Throne and Liberty Lucent</p>
                        </div>
                        <div class="flex items-center gap-2.5 p-2.5 ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/game_icon/Frame 98.png') }}" alt=""
                                    class="w-full h-full">
                            </div>
                            <p class="text-base font-normal text-text-white">Titan Realms</p>
                        </div>
                        <div class="flex items-center gap-2.5 p-2.5 ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/game_icon/Frame 97.png') }}" alt=""
                                    class="w-full h-full">
                            </div>
                            <p class="text-base font-normal text-text-white">Blade Ball Tokens</p>
                        </div>
                        <div class="flex items-center gap-2.5 p-2.5 ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/game_icon/Frame 99.png') }}" alt=""
                                    class="w-full h-full">
                            </div>
                            <p class="text-base font-normal text-text-white">Kingdoms Across Skies</p>
                        </div>
                        <div class="flex items-center gap-2.5 p-2.5 ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/game_icon/Frame1001.png') }}" alt=""
                                    class="w-full h-full">
                            </div>
                            <p class="text-base font-normal text-text-white">EA Sports FC Coins</p>
                        </div>
                        <div class="">
                            <div class="flex items-center gap-2.5 p-2.5 ">
                                <div class="w-6 h-6">
                                    <img src="{{ asset('assets/images/game_icon/Frame 111.png') }}" alt=""
                                        class="w-full h-full">
                                </div>
                                <p class="text-base font-normal text-text-white">Realmwalker: New Dawn</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-6 order-1 lg:order-2">
                    <div class="">
                        <span class="relative">
                            <x-ui.input type="text" wire:model.live.debounce.300ms="search"
                                placeholder="Search for game" class="form-input w-full text-text-white" />
                        </span>
                    </div>
                    <div class="">
                        <p class="text-xs font-normal text-text-white p-2.5 mt-2">All games</p>
                        <p class="text-base font-normal text-text-white p-2.5 mt-2">EA Sports FC Coins</p>
                        <p class="text-base font-normal text-text-white p-2.5 mt-2">Albion Online Silver</p>
                        <p class="text-base font-normal text-text-white p-2.5 mt-2">Animal Crossing: New Horizons Bells
                        </p>
                        <p class="text-base font-normal text-text-white p-2.5 mt-2">Black Desert Online Silver</p>
                        <p class="text-base font-normal text-text-white p-2.5 mt-2">Blade & Soul NEO Divine Gems</p>
                        <p class="text-base font-normal text-text-white p-2.5 mt-2">Blade Ball Tokens</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- Mobile sidebar --}}
    <div x-show="mobileMenuOpen" x-cloak @click.outside="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-100"
        class="absolute top-18 right-2 w-3/4 bg-bg-primary backdrop:blure-md z-100 rounded-lg transition-all duration-300 h-[calc(100vh-4.5rem)]">
        @include('partials.mobile-user-navigation')
    </div>
    {{-- Notification --}}
    <div x-show="notification" x-cloak @click.outside="notification = false"
        x-transition:enter="transition ease-out duration-100"
        class="absolute top-18 right-2 w-96 bg-bg-primary backdrop:blure-md z-100 rounded-lg transition-all duration-300 h-[calc(100vh-4.5rem)]">
        <h2 class="text-xl font-bold mb-4 p-2 text-text-white border-b border-bg-secondary">Notification</h2>
    </div>
</header>
