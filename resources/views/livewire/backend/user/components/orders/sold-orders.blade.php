<div class="space-y-6">
    <div class=" p-4 w-full">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">

            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">

                <div class="relative w-full sm:w-56">
                    <x-ui.select
                        class="appearance-none w-full bg-transparent border border-purple-700 text-gray-300 py-3 px-4 pr-10 rounded-lg focus:outline-none focus:border-purple-500 placeholder-gray-500">
                        <option value="">All statuses</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                    </x-ui.select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>

                <div class="relative w-full sm:w-56">
                    <x-ui.select
                        class="appearance-none w-full bg-transparent border border-purple-700 text-gray-300 py-3 px-4 pr-10 rounded-lg focus:outline-none focus:border-purple-500 placeholder-gray-500">
                        <option value="">All Game</option>
                        <option value="game1">Game 1</option>
                        <option value="game2">Game 2</option>
                        <option value="game3">Game 3</option>
                    </x-ui.select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>

                <div class="relative w-full sm:w-56">
                    <x-ui.input type="text" placeholder="Search" class="pl-5"/>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                </div>

            </div>

            <div class="w-full md:w-auto">
                <x-ui.button
                    class="w-auto py!">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span>Download invoice</span>
                </x-ui.button>
            </div>

        </div>
    </div>
    <div>
        <div class="overflow-x-auto shadow-2xl">
            <x-ui.user-table />
        </div>
    </div>
</div>
