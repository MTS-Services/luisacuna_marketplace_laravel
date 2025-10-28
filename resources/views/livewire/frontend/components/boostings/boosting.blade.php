<div>
    <div class=" text-white font-sans">
        <!-- Container -->
        <div class="max-w-7xl mx-auto px-12 py-12">

            <!-- Title -->
            <h1 class="lg:text-5xl sm:text-3xl md:text-4xl mb-8">Boosting</h1>

            <!-- Search + Filter -->
            <div class="flex flex-col sm:flex-row items-center gap-4 mb-12">
                <div
                    class="flex items-center w-full sm:flex-1 bg-transparent border border-purple-500 rounded-full px-4 py-2 focus-within:ring-2 focus-within:ring-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="white" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>

                    <input type="text" placeholder="Search"
                        class="bg-transparent w-full text-white focus:outline-none px-3" />
                </div>
                <button
                    class="flex items-center gap-2 border border-purple-500 rounded-full px-5 py-2 hover:bg-purple-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4 4v-9L3 6V4z" />
                    </svg>
                    <span>Filter</span>
                </button>
            </div>

            <!-- Popular Boosting -->
            <h2 class="lg:text-5xl sm:text-3xl md:text-4xl mb-6 text-white">Popular Boosting</h2>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

                <!-- Card 1 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/class_of_clans.png') }}" alt="Clash of Clans"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl font-medium mb-4 text-white">Clash of Clans</h3>
                        <button
                            class=" w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/fortnight.png') }}" alt="Clash of Clans"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 text-white">Fortnite
                        </h3>
                        <button
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/gensin_inpact.png') }}" alt="Clash of Clans"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 text-white">Genshin
                            Impact</h3>
                        <button
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>

            </div>
            <div class="flex space-x-2 justify-center items-center  mt-8">
                <div class="w-4 h-2 rounded-full bg-gray-200"></div>
                <div class="w-4 h-2 rounded-full bg-purple-500"></div>
                <div class="w-4 h-2 rounded-full bg-gray-200"></div>
            </div>

        </div>

        <div class="max-w-7xl mx-auto px-12 bg-[#0d0d16] ">
            <!-- Popular Boosting -->
            <h2 class="text-4xl mb-6 text-white">Newly Boosting</h2>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

                <!-- Card 1 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/darkwar.png') }}" alt="DarkWar: survival"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 text-white">DarkWar:
                            survival</h3>
                        <button
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/kingshort.png') }}" alt="Clash of Clans"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 text-white">KingShot
                        </h3>
                        <button
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/lastwar.png') }}" alt="Clash of Clans"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 text-white">Last
                            war:survival</h3>
                        <button
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>

            </div>
            <div class="flex space-x-2 justify-center items-center  mt-8">
                <div class="w-4 h-2 rounded-full bg-gray-200"></div>
                <div class="w-4 h-2 rounded-full bg-purple-500"></div>
                <div class="w-4 h-2 rounded-full bg-gray-200"></div>
            </div>

        </div>

        <div class="max-w-7xl mx-auto px-12 py-6 bg-[#0d0d16] ">
            <!-- Popular Boosting -->
            <h2 class="text-4xl mb-6 text-white">All Boosting</h2>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

                <!-- Card 1 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/ApexLegends.jpg') }}" alt="Apex Legends"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 text-white">Apex Legends
                        </h3>
                        <button
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/Battlefield.jpg') }}" alt="Battlefield"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 text-white">Battlefield
                        </h3>
                        <button
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/Black Desert Online.jpg') }}" alt="Black Desert Online"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class=" lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 text-white">Black
                            Desert Online</h3>
                        <button
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-12 py-12 bg-[#0d0d16] ">
            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

                <!-- Card 1 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/Call of Duty.jpg') }}" alt="Call of Duty"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 text-white">Call of
                            Duty</h3>
                        <button
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/Clash of Clans.png') }}" alt="Clash of Clans"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 text-white">Clash of
                            Clans</h3>
                        <button
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/Dead By Daylight.jpg') }}" alt="Dead By Daylight"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 text-white">Dead By
                            Daylight</h3>
                        <button
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-12 py-6 bg-[#0d0d16] ">
            <!-- Popular Boosting -->

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

                <!-- Card 1 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/EA Sports FC.jpg') }}" alt="EA Sports FC"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 text-white">EA Sports
                            FC</h3>
                        <button
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/Elder Scrolls Online.jpg') }}" alt="Elder Scrolls Online"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 text-white">Elder
                            Scrolls Online</h3>
                        <button
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-[#2c2c2c] rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/Escape from Tarkov.jpg') }}" alt="Escape from Tarkov"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 text-white">Escape from
                            Tarkov</h3>
                        <button
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 rounded-full transition">
                            See seller list
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex justify-center mt-8 mb-18">
                <button
                    class="lg:text-xl sm:text-1xl md:text-2xl w-full sm:w-auto bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 px-18 rounded-full transition">
                    Load More
                </button>
            </div>

        </div>

    </div>

</div>
