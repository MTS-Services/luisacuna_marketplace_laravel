 
<div>
    <div class=" flex items-center justify-center p-4 sm:p-6 md:p-8">
        <div class="w-full max-w-6xl">
            <div class="flex items-center gap-2 mb-8 text-sm">
                <span class=" text-text-primary">Home</span>
                <span class=" text-text-primary">></span>
                <span class=" text-text-primary">Seller Game</span>
            </div>
            <!-- Main Card -->
            <div class="bg-bg-primary backdrop-blur-sm rounded-3xl p-6 sm:p-8 md:p-12 border border-purple-800/30">
                <!-- Header -->
                <div class="text-center mb-8 sm:mb-10 md:mb-12">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl  mb-2 text-text-white">Sell Game Currency</h1>
                    <p class="text-base sm:text-lg text-text-secondary">Step 1/3</p>
                </div>

                <!-- Choose Game Section -->
                <div class="mb-6 sm:mb-8 bg-[#2d1f43] rounded-2xl p-4 sm:p-6 md:p-8 mx-4 sm:mx-8 md:mx-12">
                    <h2 class="text-lg sm:text-xl text-white mb-4 sm:mb-6 text-center">Choose Game</h2>

                    <!-- Info Box -->
                    <div
                        class="bg-[#3d3152] rounded-2xl p-4 sm:p-6 mb-6 border mx-0 sm:mx-6 md:mx-18 flex flex-col items-center text-center">
                        <div class="flex flex-col sm:flex-row items-center gap-3 mb-3 text-center sm:text-left">
                            <span class="text-2xl">
                                <img src="{{ asset('assets/images/game_icon/tradeshield 1.png') }}" alt="">
                            </span>
                            <h3 class="text-base sm:text-lg text-white">5 Day money hold system</h3>
                        </div>
                        <p class="text-sm sm:text-md text-gray-300 leading-relaxed max-w-2xl">
                            To safeguard our customers from potential account recovery fraud, we provide a 5-day
                            protection period on all account purchases. During this time, if a buyer experiences any
                            issues such as unauthorized access, loss, or modification of their newly purchased account,
                            they may open a dispute to work with the seller toward a resolution or request a refund.
                        </p>
                    </div>

                    <!-- Dropdown -->
                    <div class="relative mx-0 sm:mx-6 md:mx-18">
                        <select
                            class="w-full bg-bg-primary border border-purple-700/50 rounded-lg px-4 py-3 text-gray-300 appearance-none cursor-pointer hover:border-purple-600/70 focus:outline-none focus:border-purple-500 transition text-sm sm:text-base">
                            <option>Select your game</option>
                            <option>Game 1</option>
                            <option>Game 2</option>
                            <option>Game 3</option>
                        </select>
                        <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center mb-6 sm:mb-8">
                    <button
                        class="w-full sm:w-auto px-8 py-2 rounded-full bg-white text-purple-900 hover:bg-gray-100 transition">
                        Back
                    </button>
                    <button
                        class="w-full sm:w-auto px-8 py-2 rounded-full bg-[#853EFF] text-white hover:from-purple-700 hover:to-blue-700 transition">
                        Next
                    </button>
                </div>

                <!-- Footer Text -->
                <p class="text-center text-xs sm:text-sm text-text-secondary">
                    Can't find the game you want to sell? Contact our
                    <a href="#" class="text-pink-500 hover:text-pink-400 transition">customer support</a>
                    to suggest a game.
                </p>
            </div>
        </div>
    </div>
</div>
