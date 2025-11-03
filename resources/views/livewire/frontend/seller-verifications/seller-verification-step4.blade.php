<div>
    <div class="bg-bg-primary flex items-center justify-center lg:pb-0 lg:pt-0 sm:pb-32 sm:pt-12">
        <!-- Outer container -->
        <div class=" rounded-3xl lg:p-10 sm:p-10 md:p-12 w-full  flex flex-col items-center shadow-xl">
            <!-- Header -->
            <div class="text-center mb-8 sm:m-10">
                <div class="flex items-center justify-center gap-2 text-purple-400 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="#853EFF" class="w-6 h-6 sm:w-7 sm:h-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                    <h1 class="text-text-secondary text-base sm:text-lg font-medium p-2">Seller ID verification</h1>
                </div>
                <p class="text-gray-400 text-xs sm:text-sm">Step 1/6</p>
            </div>

            <!-- Card -->
            <div class="dark:bg-zinc-800/30 bg-zinc-300/20 rounded-3xl p-8 sm:p-10 md:p-12 w-full max-w-7xl shadow-xl">
                <form class="space-y-6">
                    <!-- First name -->
                    <div>
                        <label class="block text-text-white mb-2 text-md font-medium">First name</label>
                        <input type="text" placeholder="First name"
                            class="w-full bg-bg-name text-gray-200 rounded-md px-4 py-3 outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400" />
                    </div>

                    <!-- Last name -->
                    <div>
                        <label class="block text-text-white mb-2 text-sm font-medium">Last name</label>
                        <input type="text" placeholder="Last name"
                            class="w-full bg-bg-name text-gray-200 rounded-md px-4 py-3 outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400" />
                    </div>

                    <!-- Date of birth -->
                    <div>
                        <label class="block text-text-white mb-2 text-sm font-medium">Date of birth:</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <select
                                class="bg-bg-name text-white rounded-md px-4 py-3 outline-none focus:ring-2 focus:ring-purple-500">
                                <option>Year</option>
                            </select>
                            <select
                                class="bg-bg-name text-white rounded-md px-4 py-3 outline-none focus:ring-2 focus:ring-purple-500">
                                <option>Month</option>
                            </select>
                            <select
                                class="bg-bg-name text-white rounded-md px-4 py-3 outline-none focus:ring-2 focus:ring-purple-500">
                                <option>Day</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nationality -->
                    <div>
                        <label class="block text-text-white mb-2 text-sm font-medium">Nationality:</label>
                        <select
                            class="w-full bg-bg-name text-white rounded-md px-4 py-3 outline-none focus:ring-2 focus:ring-purple-500">
                            <option>Select nationality</option>
                        </select>
                        <div class="h-[1px] bg-purple-600 mt-2"></div>
                    </div>

                    <!-- Street address -->
                    <div>
                        <label class="block text-text-white mb-2 text-sm font-medium">Street address</label>
                        <input type="text" placeholder="Street address"
                            class="w-full bg-bg-name text-gray-200 rounded-md px-4 py-3 outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400" />
                    </div>

                    <!-- City -->
                    <div>
                        <label class="block text-gray-100 mb-2 text-sm font-medium">City</label>
                        <input type="text" placeholder="City"
                            class="w-full bg-bg-name text-gray-200 rounded-md px-4 py-3 outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400" />
                    </div>

                    <!-- Country -->
                    <div>
                        <label class="block text-gray-100 mb-2 text-sm font-medium">Country</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <select
                                class="bg-bg-name text-gray-200 rounded-md px-4 py-3 outline-none focus:ring-2 focus:ring-purple-500">
                                <option>Select country</option>
                            </select>
                            <input type="text" placeholder="Postal code"
                                class="bg-bg-name text-gray-200 rounded-md px-4 py-3 outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400" />
                        </div>
                    </div>
                </form>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8 sm:mt-10 w-full sm:w-auto">
                <button
                    class="px-6 py-2 bg-white text-gray-800 rounded-full font-medium hover:bg-gray-100 transition w-full sm:w-auto">
                    Back
                </button>
                <button class="px-6 py-2 bg-[#853EFF] text-white rounded-full transition w-full sm:w-auto">
                    Next
                </button>
            </div>

        </div>
    </div>
</div>
