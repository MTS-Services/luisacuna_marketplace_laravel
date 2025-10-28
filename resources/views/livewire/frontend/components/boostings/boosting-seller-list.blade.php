<div>
    <div class="container ">
        <div class="  text-white">
            <!-- Header -->
            <header class=" sm:py-4 sm:px-8 lg:py-0 lg:px-0">
                <div class=" text-white px-18 lg:px-0 md:px-0">
                    <div
                        class="max-w-[900px] mx-auto flex flex-col md:flex-row gap-4 md:items-center justify-between w-full sm:px-6 sm:py-6 lg:py-0 lg:px-0 mt-4">
                        <!-- Logo -->
                        <div class="flex gap-8">
                            <div class="h-8 w-8 bg-orange-500 rounded flex items-center justify-center font-medium">
                                <img src="{{ asset('assets/images/fortnite.png') }}" alt="">
                            </div>
                            <span class="text-xl font-medium">Fortnite</span>
                        </div>
                        <!-- Navigation Links -->
                        <nav
                            class=" peer-checked:flex flex-col lg:flex lg:flex-row gap-6 w-full lg:w-auto  lg:bg-transparent border-t border-gray-800 lg:border-none z-50">
                            <a href="#" class="navbar_style active">Items</a>
                            <a href="#" class="navbar_style">Accounts</a>
                            <a href="#" class="navbar_style">Top Ups</a>
                            <a href="#" class="navbar_style">Gift Card</a>
                        </nav>
                    </div>
                </div>
        </div>
        </header>
        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-8 py-8">
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 mb-8 text-sm">
                <span class="text-blue-100">
                    <img width="25" class="inline-block" src="{{ asset('assets/images/mdb.png') }}" alt="img">
                    Blade ball tokens</span>
                <span class="text-slate-100">></span>
                <span class="text-slate-100">Seller list</span>
            </div>

            <!-- Filters Section -->
            <div class="mb-8 space-y-4">
                <div class="flex gap-4 flex-wrap">
                    <div class="flex-1 min-w-64">
                        <div class="relative">
                            <input type="text" placeholder="Search"
                                class="w-full bg-slate-900 border border-slate-700 rounded-full px-4 py-2 pl-10 focus:outline-none focus:border-purple-500">
                            <span class="absolute left-3 top-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <select
                        class="bg-slate-900 border border-slate-700 rounded-full px-4 py-2 focus:outline-none focus:border-purple-500">
                        <option>Device</option>
                    </select>
                    <select
                        class="bg-slate-900 border border-slate-700 rounded-full px-4 py-2 focus:outline-none focus:border-purple-500">
                        <option>Account type</option>
                    </select>
                    <select
                        class="bg-slate-900 border border-slate-700 rounded-full px-4 py-2 focus:outline-none focus:border-purple-500">
                        <option>Price</option>
                    </select>
                    <select
                        class="bg-slate-900 border border-slate-700 rounded-full px-4 py-2 focus:outline-none focus:border-purple-500">
                        <option>Select Delivery Time</option>
                    </select>
                    <button class="text-slate-100 hover:text-white transition">Clear all</button>
                </div>

                <!-- Game Tags -->
                <div class="flex gap-2 flex-wrap">
                    <button
                        class="px-3 py-1 bg-slate-800/60 rounded text-sm hover:bg-slate-700 transition">Robux</button>
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Steel A
                        Brainrot</button>
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Grow A
                        Garden</button>
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Hunty
                        Zombie</button>
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">99 Nights In
                        The Forest</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">prospecting</button>
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">All Star
                        Tower
                        Defense X</button>
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Ink
                        Game</button>
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Garden Tower
                        Defense</button>
                </div>

                <div class="flex gap-2 flex-wrap">
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Bubble Gum
                        Simulator</button>
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Dead
                        Rails</button>
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">TYPE./
                        ISOUL</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Hypershot</button>
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Build A
                        Zoo</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Gems</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Rivals</button>
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">MM2</button>
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Blox
                        Fruit</button>
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Pet
                        Simulator
                        99</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Spin</button>
                    <button class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">Adopt
                        Me</button>
                </div>

                <!-- Right Filters -->
                <div class="flex gap-3 justify-end">
                    <button
                        class="px-4 py-2 border border-green-500 text-green-500 rounded-full text-sm hover:bg-green-500 hover:text-white transition">●
                        Online Seller</button>
                    <select
                        class="bg-slate-900 border border-slate-700 rounded-full px-4 py-2 focus:outline-none focus:border-purple-500">
                        <option>Recommended</option>
                    </select>
                </div>
            </div>

            <!-- Product Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                        <h3 class="text-lg font-medium mb-3">Instant EA Sports FC Coins: Build your Ultimate Team now!
                            Get
                            fast, secure, and cheap EA Sports FC Coins instantly.</h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-2 px-3 py-1 dark:text-white bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white"><img
                                    src="{{ asset('assets/images/light.png') }}" alt=""> Pc</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 dark:text-white bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white">Pickaxes:
                                0-10</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition dark:text-white text-white">Outfits:
                                None</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span
                                class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold dark:text-white">$76.28</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img"> Instants</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Victoria.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">Victoria</p>
                                <p class="text-sm text-text-secondary "> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3% |
                                    2434 reviews | 1642 Sold</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 2 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                        <h3 class="text-lg font-medium mb-3">Custom Offer! 2,000 Trophies, Prestige, 100K Push. Ultra
                            Fast
                            Delivery. Text me for info. Do not purchase directly.</h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/light.png') }}" alt=""> Pc</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Pickaxes:
                                0-10</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Outfits:
                                None</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">$76.28</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img"> Instants</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Colleen.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">Colleen</p>
                                <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3%
                                    |
                                    2434 reviews | 1642 Sold</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 3 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                        <h3 class="text-lg font-medium mb-3">Instant EA Sports FC Coins: Build your Ultimate Team now!
                            Get
                            fast, secure, and cheap EA Sports FC Coins instantly.</h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/light.png') }}" alt=""> Pc</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Pickaxes:
                                0-10</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Outfits:
                                None</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">$76.28</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                Instants</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Esther.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">Esther</p>
                                <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3%
                                    |
                                    2434 reviews | 1642 Sold</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 4 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                        <h3 class="text-lg font-medium mb-3">Instant EA Sports FC Coins: Build your Ultimate Team now!
                            Get
                            fast, secure, and cheap EA Sports FC Coins instantly.</h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/light.png') }}" alt=""> Pc</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Pickaxes:
                                0-10</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Outfits:
                                None</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">$76.28</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                Instants</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Shane.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">Shane</p>
                                <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3%
                                    |
                                    2434 reviews | 1642 Sold</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 5 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                        <h3 class="text-lg font-medium mb-3">Custom Offer! 2,000 Trophies, Prestige, 100K Push. Ultra
                            Fast
                            Delivery. Text me for info. Do not purchase directly.</h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/light.png') }}" alt=""> Pc</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Pickaxes:
                                0-10</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Outfits:
                                None</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">$76.28</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                Instants</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Arthur.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">Arthur</p>
                                <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3%
                                    |
                                    2434 reviews | 1642 Sold</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 6 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                        <h3 class="text-lg font-medium mb-3">Instant EA Sports FC Coins: Build your Ultimate Team now!
                            Get
                            fast, secure, and cheap EA Sports FC Coins instantly.</h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/light.png') }}" alt=""> Pc</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Pickaxes:
                                0-10</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Outfits:
                                None</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">$76.28</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                Instants</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Kristin.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">Kristin</p>
                                <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3%
                                    |
                                    2434 reviews | 1642 Sold</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 7 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                        <h3 class="text-lg font-medium mb-3">Instant EA Sports FC Coins: Build your Ultimate Team now!
                            Get
                            fast, secure, and cheap EA Sports FC Coins instantly.</h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/light.png') }}" alt=""> Pc</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Pickaxes:
                                0-10</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Outfits:
                                None</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">$76.28</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                Instants</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Angel.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">Angel</p>
                                <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3%
                                    |
                                    2434 reviews | 1642 Sold</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 8 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                        <h3 class="text-lg font-medium mb-3">Instant EA Sports FC Coins: Build your Ultimate Team now!
                            Get
                            fast, secure, and cheap EA Sports FC Coins instantly.</h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/light.png') }}" alt=""> Pc</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Pickaxes:
                                0-10</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Outfits:
                                None</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">$76.28</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                Instants</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Marjorie.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">Marjorie</p>
                                <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3%
                                    |
                                    2434 reviews | 1642 Sold</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 9 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                        <h3 class="text-lg font-medium mb-3">Instant EA Sports FC Coins: Build your Ultimate Team now!
                            Get
                            fast, secure, and cheap EA Sports FC Coins instantly.</h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/light.png') }}" alt=""> Pc</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Pickaxes:
                                0-10</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Outfits:
                                None</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">$76.28</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                Instants</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Soham.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">Soham</p>
                                <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3%
                                    |
                                    2434 reviews | 1642 Sold</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="flex justify-end items-center space-x-3  p-4 m-10">
                <button class="text-white text-sm hover:text-purple-500">Previous</button>

                <button class="bg-purple-600 text-white text-sm px-3 py-1 rounded">1</button>
                <button class="text-white text-sm hover:text-purple-500">2</button>
                <button class="text-white text-sm hover:text-purple-500">3</button>
                <button class="text-white text-sm hover:text-purple-500">4</button>
                <button class="text-white text-sm hover:text-purple-500">5</button>

                <button class="text-white text-sm hover:text-purple-500">Next</button>
            </div>
        </main>
    </div>
</div>
</div>
