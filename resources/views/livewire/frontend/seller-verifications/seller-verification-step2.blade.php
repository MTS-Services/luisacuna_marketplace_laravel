<div>
    <div class="bg-bg-primary flex items-center justify-center pb-20 pt-8 sm:pb-32 sm:pt-12">
        <!-- Outer container -->
        <div class=" rounded-3xl lg:p-20 sm:p-10 md:p-12 w-full max-w-7xl flex flex-col items-center shadow-xl">
            <!-- Header -->
            <div class="text-center mb-8 sm:mb-10">
                <div class="flex items-center justify-center gap-2 text-purple-400 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="#853EFF" class="w-6 h-6 sm:w-7 sm:h-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                    <h1 class="text-text-secondary text-base sm:text-lg font-medium">Seller ID verification</h1>
                </div>
                <p class="text-gray-400 text-xs sm:text-sm">Step 1/6</p>
            </div>

            <!-- Card -->
            <div class="p-6 sm:p-8 md:p-10 bg-[#2d1f43] rounded-3xl w-full">
                <div class="bg-[#3d3152] px-6 sm:px-10 md:px-20 rounded-3xl w-full py-6 sm:py-8 md:py-10">
                    <h2 class="text-white text-base sm:text-lg font-medium mb-6 text-center sm:text-left">
                        Select the categories you'll be selling in:
                    </h2>

                    <!-- Radio buttons -->
                    <div class="flex flex-col gap-4">
                        <label class="flex items-center gap-2  cursor-pointer">
                            <input type="radio" name="seller_type" value="individual" checked
                                class="accent-[#FF2E91] w-4 h-4">
                            <span class="text-white">Currency</span>
                        </label>

                        <label class="flex items-center gap-2  cursor-pointer">
                            <input type="radio" name="seller_type" value="individual" checked
                                class="accent-[#FF2E91] w-4 h-4">
                            <span class="text-white">Accounts</span>
                        </label>

                        <label class="flex items-center gap-2  cursor-pointer">
                            <input type="radio" name="seller_type" value="individual" checked
                                class="accent-[#FF2E91] w-4 h-4">
                            <span class="text-white">Items</span>
                        </label>

                        <label class="flex items-center gap-2  cursor-pointer">
                            <input type="radio" name="seller_type" value="individual" checked
                                class="accent-[#FF2E91] w-4 h-4">
                            <span class="text-white">Top Ups</span>
                        </label>

                        <label class="flex items-center gap-2  cursor-pointer">
                            <input type="radio" name="seller_type" value="individual" checked
                                class="accent-[#FF2E91] w-4 h-4">
                            <span class="text-white">Boosting</span>
                        </label>

                        <label class="flex items-center gap-2  cursor-pointer">
                            <input type="radio" name="seller_type" value="company"
                                class="accent-[#FF2E91] w-4 h-4">
                            <span class="text-white">Gift Cards</span>
                        </label>
                    </div>

                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8 sm:mt-10 w-full sm:w-auto">
                <button
                    class="px-6 py-2 bg-white text-gray-800 rounded-full font-medium hover:bg-gray-100 transition w-full sm:w-auto">
                    Back
                </button>
                <button
                    class="px-6 py-2 bg-[#853EFF] text-white rounded-full transition w-full sm:w-auto">
                    Next
                </button>
            </div>

        </div>
    </div>
</div>
