<div class="min-h-screen w-full   px-4 py-10 flex justify-center">
    <div class="max-w-7xl w-full">

        <!-- Heading -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-semibold text-text-white">Start selling</h1>
            <p class="text-text-white mt-2">
                Select the services you can provide to receive notifications from <br> the buyers
            </p>
            <button class="text-pink-400 text-sm mt-2 ">How it works</button>
        </div>

        <!-- Game Card -->
        <div class="bg-bg-border2 rounded-xl p-6 shadow-lg  ">
            <div class="flex items-center gap-3">
                <img src="https://images.pexels.com/photos/1054655/pexels-photo-1054655.jpeg?cs=srgb&dl=pexels-hsapir-1054655.jpg&fm=jpg"
                    class="w-12 h-12 rounded-lg object-cover">
                <div>
                    <h2 class="text-text-white font-semibold text-lg">Anime Vanguards</h2>
                    <p class="text-pink-400 text-sm">Subscribe 3/6</p>
                </div>
            </div>

            <!-- Toggles -->
            <div class="mt-6 space-y-5">
                <!-- Unit Obtaining -->
                <div class="flex justify-between items-center text-text-white">
                    <span>Points & Currency</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-10 h-5 bg-gray-600 rounded-full peer peer-checked:bg-purple-500 transition-all">
                        </div>
                        <div
                            class="absolute left-0.5 top-0.5 w-4 h-4 bg-bg-white rounded-full transition-all peer-checked:translate-x-5">
                        </div>
                    </label>
                </div>

                <!-- Points & Currency -->

                <div class="flex justify-between items-center text-text-white">
                    <span>Points & Currency</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-10 h-5 bg-gray-600 rounded-full peer peer-checked:bg-purple-500 transition-all">
                        </div>
                        <div
                            class="absolute left-0.5 top-0.5 w-4 h-4 bg-bg-white rounded-full transition-all peer-checked:translate-x-5">
                        </div>
                    </label>
                </div>

                <!-- Quests -->
                <div class="flex justify-between items-center text-text-white">
                    <span>Quests</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-10 h-5 bg-gray-600 rounded-full peer peer-checked:bg-purple-500 transition-all">
                        </div>
                        <div
                            class="absolute left-0.5 top-0.5 w-4 h-4 bg-bg-white rounded-full transition-all peer-checked:translate-x-5">
                        </div>
                    </label>
                </div>


                <!-- Stage Carry -->
                <div class="flex justify-between items-center text-text-white">
                    <span>Stage Carry</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-10 h-5 bg-gray-600 rounded-full peer peer-checked:bg-purple-500 transition-all">
                        </div>
                        <div
                            class="absolute left-0.5 top-0.5 w-4 h-4 bg-bg-white rounded-full transition-all peer-checked:translate-x-5">
                        </div>
                    </label>
                </div>

                <!-- Materials Grinding -->
                <div class="flex justify-between items-center text-text-white">
                    <span>Materials Grinding</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-10 h-5 bg-gray-600 rounded-full peer peer-checked:bg-purple-500 transition-all">
                        </div>
                        <div
                            class="absolute left-0.5 top-0.5 w-4 h-4 bg-bg-white rounded-full transition-all peer-checked:translate-x-5">
                        </div>
                    </label>
                </div>

                <!-- Custom Request -->
                <div class="flex justify-between items-center text-text-white">
                    <span>Custom Request</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-10 h-5 bg-gray-600 rounded-full peer peer-checked:bg-purple-500 transition-all">
                        </div>
                        <div
                            class="absolute left-0.5 top-0.5 w-4 h-4 bg-bg-white rounded-full transition-all peer-checked:translate-x-5">
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div x-data="{ open: false }" class="bg-bg-border2 rounded-xl p-6 shadow-lg    mt-6">
            <!-- Header -->
            <div class="flex justify-between items-center cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <img src="https://images.pexels.com/photos/1054655/pexels-photo-1054655.jpeg?cs=srgb&dl=pexels-hsapir-1054655.jpg&fm=jpg"
                        class="w-12 h-12 rounded-lg object-cover" alt="Albion Online">
                    <div>
                        <h2 class="text-text-white font-semibold text-lg">Albion Online</h2>
                        <p class="text-gray-400 text-sm">Not subscribed</p>
                    </div>
                </div>

                <!-- Arrow -->
                <div>
                    <svg class="w-5 h-5 text-text-white transition-transform duration-300"
                        :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <!-- Collapsible Content -->
            <div x-show="open" x-transition.origin.top class="mt-6 text-text-white space-y-4">

                <p class="text-sm text-gray-300">Coming soon...</p>

                <div class="p-4 bg-bg-border2 rounded-lg  ">
                    <p class="text-sm text-gray-200">Service options will appear here.</p>
                </div>
            </div>
        </div>

        <div x-data="{ open: false }" class="bg-bg-border2 rounded-xl p-6 shadow-lg   mt-6">
            <!-- Header -->
            <div class="flex justify-between items-center cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <img src="https://images.pexels.com/photos/1054655/pexels-photo-1054655.jpeg?cs=srgb&dl=pexels-hsapir-1054655.jpg&fm=jpg"
                        class="w-12 h-12 rounded-lg object-cover">
                    <div>
                        <h2 class="text-text-white font-semibold text-lg">Apex Legends</h2>
                        <p class="text-gray-400 text-sm">Not subscribed</p>
                    </div>
                </div>

                <!-- Arrow -->
                <div>
                    <svg class="w-5 h-5 text-text-white transition-transform duration-300"
                        :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <!-- Collapsible Content -->
            <div x-show="open" x-transition.origin.top class="mt-6 text-text-white space-y-4">

                <p class="text-sm text-gray-300">Coming soon...</p>

                <div class="p-4 bg-bg-border2 rounded-lg  ">
                    <p class="text-sm text-gray-200">Service options will appear here.</p>
                </div>
            </div>
        </div>

        <div x-data="{ open: false }" class="bg-bg-border2 rounded-xl p-6 shadow-lg   mt-6">
            <!-- Header -->
            <div class="flex justify-between items-center cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <img src="https://images.pexels.com/photos/1054655/pexels-photo-1054655.jpeg?cs=srgb&dl=pexels-hsapir-1054655.jpg&fm=jpg"
                        class="w-12 h-12 rounded-lg object-cover">
                    <div>
                        <h2 class="text-text-white font-semibold text-lg">ArcheAge</h2>
                        <p class="text-gray-400 text-sm">Not subscribed</p>
                    </div>
                </div>

                <!-- Arrow -->
                <div>
                    <svg class="w-5 h-5 text-text-white transition-transform duration-300"
                        :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <!-- Collapsible Content -->
            <div x-show="open" x-transition.origin.top class="mt-6 text-text-white space-y-4">

                <p class="text-sm text-gray-300">Coming soon...</p>

                <div class="p-4 bg-bg-border2 rounded-lg  ">
                    <p class="text-sm text-gray-200">Service options will appear here.</p>
                </div>
            </div>
        </div>

        <div x-data="{ open: false }" class="bg-bg-border2 rounded-xl p-6 shadow-lg   mt-6">
            <!-- Header -->
            <div class="flex justify-between items-center cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <img src="https://images.pexels.com/photos/1054655/pexels-photo-1054655.jpeg?cs=srgb&dl=pexels-hsapir-1054655.jpg&fm=jpg"
                        class="w-12 h-12 rounded-lg object-cover">
                    <div>
                        <h2 class="text-text-white font-semibold text-lg">Black Desert Online</h2>
                        <p class="text-gray-400 text-sm">Not subscribed</p>
                    </div>
                </div>

                <!-- Arrow -->
                <div>
                    <svg class="w-5 h-5 text-text-white transition-transform duration-300"
                        :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <!-- Collapsible Content -->
            <div x-show="open" x-transition.origin.top class="mt-6 text-text-white space-y-4">

                <p class="text-sm text-gray-300">Coming soon...</p>

                <div class="p-4 bg-bg-border2 rounded-lg  ">
                    <p class="text-sm text-gray-200">Service options will appear here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
