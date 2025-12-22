<div class="min-h-screen w-full px-4 py-10 flex justify-center bg-bg-primary">
    <div class="container bg-bg-secondary p-4 sm:p-10 md:p-20 rounded-2xl">

        <!-- Heading -->
        <div class="text-center mb-4 sm:mb-10 px-4 sm:px-10 md:px-16 lg:px-32 xl:px-48">
            <h2 class="text-2xl sm:text-40px font-semibold text-text-white">{{ __('Start selling') }}</h2>
            <p class="text-text-white text-base sm:text-2xl py-3">
                {{ __('Select the services you can provide to receive notifications from the buyers') }}
            </p>
            <button class="text-pink-500 text-base font-normal mt-2">{{ __('How it works') }}</button>
        </div>

        <!-- Game Card -->
        <div class="bg-bg-info rounded-xl p-3 sm:p-10">
            <div class="flex items-center gap-3">
                <div class="w-16 h-16">
                    <img src="{{ asset('assets/images/subcribe/sub (2).png') }}"
                        class="w-full h-full rounded-2xl object-cover">
                </div>
                <div>
                    <h2 class="text-text-white font-semibold text-xl sm:text-3xl mb-1">{{ __('Anime Vanguards') }}</h2>
                    <p class="text-pink-500 text-base font-normal">{{ __('Subscribe 3/6') }}</p>
                </div>
            </div>

            <!-- Toggles -->
            <div class="mt-6 space-y-5">
                <!-- Unit Obtaining -->
                <div class="flex justify-between items-center text-text-white">
                    <h2 class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Unit Obtaining') }}</h2>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <!-- Slider background -->
                        <div class="w-10 h-5 rounded-full transition-all bg-gray-600 peer-checked:bg-bg-white"></div>
                        <!-- Knob (button) -->
                        <div
                            class="absolute left-0.5 top-0.5 w-4 h-4 rounded-full transition-all bg-bg-white peer-checked:bg-zinc-500 peer-checked:translate-x-5">
                        </div>
                    </label>
                </div>




                <!-- Points & Currency -->
                <div class="flex justify-between items-center text-text-white">
                    <h2 class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Points & Currency') }}</h2>
                   <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <!-- Slider background -->
                        <div class="w-10 h-5 rounded-full transition-all bg-gray-600 peer-checked:bg-bg-white"></div>
                        <!-- Knob (button) -->
                        <div
                            class="absolute left-0.5 top-0.5 w-4 h-4 rounded-full transition-all bg-bg-white peer-checked:bg-zinc-500 peer-checked:translate-x-5">
                        </div>
                    </label>
                </div>

                <!-- Quests -->
                <div class="flex justify-between items-center text-text-white">
                    <h2 class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Quests') }}</h2>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <!-- Slider background -->
                        <div class="w-10 h-5 rounded-full transition-all bg-gray-600 peer-checked:bg-bg-white"></div>
                        <!-- Knob (button) -->
                        <div
                            class="absolute left-0.5 top-0.5 w-4 h-4 rounded-full transition-all bg-bg-white peer-checked:bg-zinc-500 peer-checked:translate-x-5">
                        </div>
                    </label>
                </div>


                <!-- Stage Carry -->
                <div class="flex justify-between items-center text-text-white">
                    <h2 class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Stage Carry') }}</h2>
                   <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <!-- Slider background -->
                        <div class="w-10 h-5 rounded-full transition-all bg-gray-600 peer-checked:bg-bg-white"></div>
                        <!-- Knob (button) -->
                        <div
                            class="absolute left-0.5 top-0.5 w-4 h-4 rounded-full transition-all bg-bg-white peer-checked:bg-zinc-500 peer-checked:translate-x-5">
                        </div>
                    </label>
                </div>

                <!-- Materials Grinding -->
                <div class="flex justify-between items-center text-text-white">
                    <h2 class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Materials Grinding') }}</h2>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <!-- Slider background -->
                        <div class="w-10 h-5 rounded-full transition-all bg-gray-600 peer-checked:bg-bg-white"></div>
                        <!-- Knob (button) -->
                        <div
                            class="absolute left-0.5 top-0.5 w-4 h-4 rounded-full transition-all bg-bg-white peer-checked:bg-zinc-500 peer-checked:translate-x-5">
                        </div>
                    </label>
                </div>

                <!-- Custom Request -->
                <div class="flex justify-between items-center text-text-white">
                    <h2 class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Custom Request') }}</h2>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <!-- Slider background -->
                        <div class="w-10 h-5 rounded-full transition-all bg-gray-600 peer-checked:bg-bg-white"></div>
                        <!-- Knob (button) -->
                        <div
                            class="absolute left-0.5 top-0.5 w-4 h-4 rounded-full transition-all bg-bg-white peer-checked:bg-zinc-500 peer-checked:translate-x-5">
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div x-data="{ open: false }" class="bg-bg-info rounded-xl p-3 sm:p-10 mt-4 sm:mt-10">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/subcribe/sub (3).png') }}"
                            class="w-full h-full rounded-2xl object-cover">
                    </div>
                    <div>
                        <h2 class="text-text-white font-semibold text-xl sm:text-3xl">{{ __('Albion Online') }}</h2>
                        <p class="text-text-white text-base font-normal">{{ __('Not subscribed') }}</p>
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

                <p class="text-text-white text-base font-semibold">{{ __('Coming soon...') }}</p>

                <div class="bg-bg-optional rounded-2xl p-4">
                    <p class="text-text-white">{{ __('Service options will appear here.') }}</p>
                </div>
            </div>
        </div>
        <div x-data="{ open: false }" class="bg-bg-info rounded-xl p-3 sm:p-10 mt-4 sm:mt-10">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/subcribe/sub (4).png') }}"
                            class="w-full h-full rounded-2xl object-cover">
                    </div>
                    <div>
                        <h2 class="text-text-white font-semibold text-xl sm:text-3xl">{{ __('Apex Legends') }}</h2>
                        <p class="text-text-white text-base font-normal">{{ __('Not subscribed') }}</p>
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

                <p class="text-text-white text-base font-semibold">{{ __('Coming soon...') }}</p>

                <div class="bg-bg-optional rounded-2xl p-4">
                    <p class="text-text-white">{{ __('Service options will appear here.') }}</p>
                </div>
            </div>
        </div>
        <div x-data="{ open: false }" class="bg-bg-info rounded-xl p-3 sm:p-10 mt-4 sm:mt-10">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/subcribe/sub (5).png') }}"
                            class="w-full h-full rounded-2xl object-cover">
                    </div>
                    <div>
                        <h2 class="text-text-white font-semibold text-xl sm:text-3xl">{{ __('ArcheAge') }}</h2>
                        <p class="text-text-white text-base font-normal">{{ __('Not subscribed') }}</p>
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

                <p class="text-text-white text-base font-semibold">{{ __('Coming soon...') }}</p>

                <div class="bg-bg-optional rounded-2xl p-4">
                    <p class="text-text-white">{{ __('Service options will appear here.') }}</p>
                </div>
            </div>
        </div>
        <div x-data="{ open: false }" class="bg-bg-info rounded-xl p-3 sm:p-10 mt-4 sm:mt-10">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/subcribe/sub (6).png') }}"
                            class="w-full h-full rounded-2xl object-cover">
                    </div>
                    <div>
                        <h2 class="text-text-white font-semibold text-xl sm:text-3xl">{{ __('Black Desert Online') }}
                        </h2>
                        <p class="text-text-white text-base font-normal">{{ __('Not subscribed') }}</p>
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

                <p class="text-text-white text-base font-semibold">{{ __('Coming soon...') }}</p>

                <div class="bg-bg-optional rounded-2xl p-4">
                    <p class="text-text-white">{{ __('Service options will appear here.') }}</p>
                </div>
            </div>
        </div>
        <div x-data="{ open: false }" class="bg-bg-info rounded-xl p-3 sm:p-10 mt-4 sm:mt-10">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/subcribe/sub (6).png') }}"
                            class="w-full h-full rounded-2xl object-cover">
                    </div>
                    <div>
                        <h2 class="text-text-white font-semibold text-xl sm:text-3xl">{{ __('Call of Duty') }}</h2>
                        <p class="text-text-white text-base font-normal">{{ __('Not subscribed') }}</p>
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

                <p class="text-text-white text-base font-semibold">{{ __('Coming soon...') }}</p>

                <div class="bg-bg-optional rounded-2xl p-4">
                    <p class="text-text-white">{{ __('Service options will appear here.') }}</p>
                </div>
            </div>
        </div>
        <div x-data="{ open: false }" class="bg-bg-info rounded-xl p-3 sm:p-10 mt-4 sm:mt-10">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/subcribe/sub (6).png') }}"
                            class="w-full h-full rounded-2xl object-cover">
                    </div>
                    <div>
                        <h2 class="text-text-white font-semibold text-xl sm:text-3xl">{{ __('Clash of Clans') }}</h2>
                        <p class="text-text-white text-base font-normal">{{ __('Not subscribed') }}</p>
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

                <p class="text-text-white text-base font-semibold">{{ __('Coming soon...') }}</p>

                <div class="bg-bg-optional rounded-2xl p-4">
                    <p class="text-text-white">{{ __('Service options will appear here.') }}</p>
                </div>
            </div>
        </div>
        <div x-data="{ open: false }" class="bg-bg-info rounded-xl p-3 sm:p-10 mt-4 sm:mt-10">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/subcribe/sub (6).png') }}"
                            class="w-full h-full rounded-2xl object-cover">
                    </div>
                    <div>
                        <h2 class="text-text-white font-semibold text-xl sm:text-3xl">{{ __('Clash Royale') }}</h2>
                        <p class="text-text-white text-base font-normal">{{ __('Not subscribed') }}</p>
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

                <p class="text-text-white text-base font-semibold">{{ __('Coming soon...') }}</p>

                <div class="bg-bg-optional rounded-2xl p-4">
                    <p class="text-text-white">{{ __('Service options will appear here.') }}</p>
                </div>
            </div>
        </div>
        <div x-data="{ open: false }" class="bg-bg-info rounded-xl p-3 sm:p-10 mt-4 sm:mt-10">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/subcribe/sub (6).png') }}"
                            class="w-full h-full rounded-2xl object-cover">
                    </div>
                    <div>
                        <h2 class="text-text-white font-semibold text-xl sm:text-3xl">{{ __('Counter-Strike 2') }}
                        </h2>
                        <p class="text-text-white text-base font-normal">{{ __('Not subscribed') }}</p>
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

                <p class="text-text-white text-base font-semibold">{{ __('Coming soon...') }}</p>

                <div class="bg-bg-optional rounded-2xl p-4">
                    <p class="text-text-white">{{ __('Service options will appear here.') }}</p>
                </div>
            </div>
        </div>
        <div x-data="{ open: false }" class="bg-bg-info rounded-xl p-3 sm:p-10 mt-4 sm:mt-10">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/subcribe/sub (6).png') }}"
                            class="w-full h-full rounded-2xl object-cover">
                    </div>
                    <div>
                        <h2 class="text-text-white font-semibold text-xl sm:text-3xl">{{ __('Diablo 4') }}</h2>
                        <p class="text-text-white text-base font-normal">{{ __('Not subscribed') }}</p>
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

                <p class="text-text-white text-base font-semibold">{{ __('Coming soon...') }}</p>

                <div class="bg-bg-optional rounded-2xl p-4">
                    <p class="text-text-white">{{ __('Service options will appear here.') }}</p>
                </div>
            </div>
        </div>
        <div x-data="{ open: false }" class="bg-bg-info rounded-xl p-3 sm:p-10 mt-4 sm:mt-10">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/subcribe/sub (1).png') }}"
                            class="w-full h-full rounded-2xl object-cover">
                    </div>
                    <div>
                        <h2 class="text-text-white font-semibold text-xl sm:text-3xl">{{ __('Dota 2') }}</h2>
                        <p class="text-text-white text-base font-normal">{{ __('Not subscribed') }}</p>
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

                <p class="text-text-white text-base font-semibold">{{ __('Coming soon...') }}</p>

                <div class="bg-bg-optional rounded-2xl p-4">
                    <p class="text-text-white">{{ __('Service options will appear here.') }}</p>
                </div>
            </div>
        </div>
        <div x-data="{ open: false }" class="bg-bg-info rounded-xl p-3 sm:p-10 mt-4 sm:mt-10">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/subcribe/sub (6).png') }}"
                            class="w-full h-full rounded-2xl object-cover">
                    </div>
                    <div>
                        <h2 class="text-text-white font-semibold text-xl sm:text-3xl">{{ __('EA Sports FC 24') }}</h2>
                        <p class="text-text-white text-base font-normal">{{ __('Not subscribed') }}</p>
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

                <p class="text-text-white text-base font-semibold">{{ __('Coming soon...') }}</p>

                <div class="bg-bg-optional rounded-2xl p-4">
                    <p class="text-text-white">{{ __('Service options will appear here.') }}</p>
                </div>
            </div>
        </div>
        <div x-data="{ open: false }" class="bg-bg-info rounded-xl p-3 sm:p-10 mt-4 sm:mt-10">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/subcribe/sub (6).png') }}"
                            class="w-full h-full rounded-2xl object-cover">
                    </div>
                    <div>
                        <h2 class="text-text-white font-semibold text-xl sm:text-3xl">{{ __('Elden Ring') }}</h2>
                        <p class="text-text-white text-base font-normal">{{ __('Not subscribed') }}</p>
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

                <p class="text-text-white text-base font-semibold">{{ __('Coming soon...') }}</p>

                <div class="bg-bg-optional rounded-2xl p-4">
                    <p class="text-text-white">{{ __('Service options will appear here.') }}</p>
                </div>
            </div>
        </div>
        <div x-data="{ open: false }" class="bg-bg-info rounded-xl p-3 sm:p-10 mt-4 sm:mt-10">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/subcribe/sub (6).png') }}"
                            class="w-full h-full rounded-2xl object-cover">
                    </div>
                    <div>
                        <h2 class="text-text-white font-semibold text-xl sm:text-3xl">{{ __('Escape from Tarkov') }}
                        </h2>
                        <p class="text-text-white text-base font-normal">{{ __('Not subscribed') }}</p>
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

                <p class="text-text-white text-base font-semibold">{{ __('Coming soon...') }}</p>

                <div class="bg-bg-optional rounded-2xl p-4">
                    <p class="text-text-white">{{ __('Service options will appear here.') }}</p>
                </div>
            </div>
        </div>
        <div x-data="{ open: false }" class="bg-bg-info rounded-xl p-3 sm:p-10 mt-4 sm:mt-10">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/subcribe/sub (6).png') }}"
                            class="w-full h-full rounded-2xl object-cover">
                    </div>
                    <div>
                        <h2 class="text-text-white font-semibold text-xl sm:text-3xl">{{ __('Eve Online') }}</h2>
                        <p class="text-text-white text-base font-normal">{{ __('Not subscribed') }}</p>
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

                <p class="text-text-white text-base font-semibold">{{ __('Coming soon...') }}</p>

                <div class="bg-bg-optional rounded-2xl p-4">
                    <p class="text-text-white">{{ __('Service options will appear here.') }}</p>
                </div>
            </div>
        </div>

        {{-- <div x-data="{ open: false }" class="bg-bg-border2 rounded-xl p-6 shadow-lg border border-[#2a1b3c] mt-6">
            <!-- Header -->
            <div class="flex justify-between cursor-pointer" @click="open = !open">

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

                <div class="p-4 bg-bg-border2 rounded-lg border border-[#3a2b4d]">
                    <p class="text-text-white">Service options will appear here.</p>
                </div>
            </div>
        </div>

        <div x-data="{ open: false }" class="bg-bg-border2 rounded-xl p-6 shadow-lg border border-[#2a1b3c] mt-6">
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

                <div class="p-4 bg-bg-border2 rounded-lg border border-[#3a2b4d]">
                    <p class="text-text-white">Service options will appear here.</p>
                </div>
            </div>
        </div>

        <div x-data="{ open: false }" class="bg-bg-border2 rounded-xl p-6 shadow-lg border border-[#2a1b3c] mt-6">
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

                <div class="p-4 bg-bg-border2 rounded-lg border border-[#3a2b4d]">
                    <p class="text-text-white">Service options will appear here.</p>
                </div>
            </div>
        </div>
    </div> --}}
    </div>
