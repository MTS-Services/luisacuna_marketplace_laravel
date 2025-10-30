<div class="space-y-6">
    <div class=" p-4 w-full">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">

            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">

                <div class="relative w-full sm:w-56">
                    <x-ui.select>
                        <option value="">All statuses</option>
                        <option value="Active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                    </x-ui.select>
                </div>

                <div class="relative w-full sm:w-56">
                    <x-ui.select>
                        <option value="">All Game</option>
                        <option value="game1">Game 1</option>
                        <option value="game2">Game 2</option>
                        <option value="game3">Game 3</option>
                    </x-ui.select>
                </div>

                <div class="relative w-full sm:w-56">
                    <x-ui.input type="text" placeholder="Search" class="pl-5" />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <x-phosphor-magnifying-glass class="w-5 h-5 fill-text-text-white" />
                    </div>
                </div>

            </div>

            <div class="w-full md:w-auto">
                <x-ui.button class="w-auto py!">
                    <x-phosphor-download class="w-5 h-5 fill-text-text-white" />
                    <span>Download invoice</span>
                </x-ui.button>
            </div>

        </div>
    </div>
    <div>
        <div class="overflow-x-auto shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left table-auto border-separate border-spacing-0">
                    <thead>
                        <tr class="text-sm text-text-white uppercase tracking-wider">
                            <th
                                class="px-2 sm:px-4 md:px-6 py-5 text-sm md:text-base text-text-white capitalize font-normal items-center gap-1 flex">
                                Game
                                <div>
                                    <x-phosphor-caret-up-fill class="w-4 h-4 fill-zinc-500" />
                                    <x-phosphor-caret-down-fill class='w-4 h-4' />
                                </div>
                            </th>
                            <th
                                class="px-2 sm:px-4 md:px-6 py-5 text-sm md:text-base text-text-white capitalize font-normal">
                                Quantity
                            </th>
                            <th
                                class="px-2 sm:px-4 md:px-6 py-5 text-sm md:text-base text-text-white capitalize font-normal">
                                Minimum quantity
                            </th>
                            <th
                                class="px-2 sm:px-4 md:px-6 py-5 text-sm md:text-base text-text-white capitalize font-normal whitespace-nowrap">
                                Price</th>
                            <th
                                class="px-2 sm:px-4 md:px-6 py-5 text-sm md:text-base text-text-white capitalize font-normal whitespace-nowrap">
                                Status</th>
                            <th
                                class="px-2 sm:px-4 md:px-6 py-5 text-sm md:text-base text-text-white capitalize font-normal">
                                Delivery time</th>
                            <th
                                class="px-2 sm:px-4 md:px-6 py-5 text-sm md:text-base text-text-white capitalize font-normal">
                                Actions
                                ($)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800">
                        <tr class="bg-bg-primary hover:bg-bg-hover transition-colors">
                            <td class="px-4 md:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 xxs:w-10 xxs:h-10 rounded-lg flex-shrink-0">
                                        <img src="{{ asset('assets/images/order.png') }}" alt="Fortnite Logo"
                                            class="w-full h-full rounded-lg object-cover" />
                                    </div>
                                    <div class="min-w-0">
                                        <h3
                                            class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">
                                            Fortnite</h3>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm">1B</td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm hidden sm:table-cell">100k
                            </td>
                            <td
                                class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm whitespace-nowrap hidden lg:table-cell">
                                $6.5 (100k)</td>
                            <td class="px-4 md:px-6 py-4">
                                <span
                                    class="px-2 xxs:px-3 py-1 text-xs font-semibold rounded-full bg-pink-500 text-white whitespace-nowrap inline-block">Active</span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm hidden md:table-cell">1 h
                            </td>
                            <td class="px-4 md:px-6 py-3 rounded-r-lg">
                                <div class="flex items-center gap-3 text-text-muted">
                                    <x-phosphor-pause-fill class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-link-fill class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-pencil-simple-fill
                                        class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-trash-fill class="w-5 h-5 cursor-pointer hover:text-status-paused" />
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-bg-secondary hover:bg-bg-hover transition-colors">
                            <td class="px-4 md:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 xxs:w-10 xxs:h-10 rounded-lg flex-shrink-0">
                                        <img src="{{ asset('assets/images/order.png') }}" alt="Fortnite Logo"
                                            class="w-full h-full rounded-lg object-cover" />
                                    </div>
                                    <div class="min-w-0">
                                        <h3
                                            class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">
                                            Fortnite</h3>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm">2B</td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm hidden sm:table-cell">200K
                            </td>
                            <td
                                class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm whitespace-nowrap hidden lg:table-cell">
                                $9.5 (200k)</td>
                            <td class="px-4 md:px-6 py-4">
                                <span
                                    class="px-2 xxs:px-3 py-1 text-xs font-semibold rounded-full bg-pink-500 text-white whitespace-nowrap inline-block">Active</span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm hidden md:table-cell">10 min
                            </td>
                            <td class="px-4 md:px-6 py-3 rounded-r-lg">
                                <div class="flex items-center gap-3 text-text-muted">
                                    <x-phosphor-pause-fill class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-link-fill class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-pencil-simple-fill
                                        class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-trash-fill class="w-5 h-5 cursor-pointer hover:text-status-paused" />
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-bg-primary hover:bg-bg-hover transition-colors">
                            <td class="px-4 md:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 xxs:w-10 xxs:h-10 rounded-lg flex-shrink-0">
                                        <img src="{{ asset('assets/images/order.png') }}" alt="Fortnite Logo"
                                            class="w-full h-full rounded-lg object-cover" />
                                    </div>
                                    <div class="min-w-0">
                                        <h3
                                            class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">
                                            Fortnite</h3>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm">2M</td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm hidden sm:table-cell">1K
                            </td>
                            <td
                                class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm whitespace-nowrap hidden lg:table-cell">
                                $6 (1k)</td>
                            <td class="px-4 md:px-6 py-4">
                                <span
                                    class="px-2 xxs:px-3 py-1 text-xs font-semibold rounded-full bg-pink-500 text-white whitespace-nowrap inline-block">Active</span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm hidden md:table-cell">15 min
                            </td>
                            <td class="px-4 md:px-6 py-3 rounded-r-lg">
                                <div class="flex items-center gap-3 text-text-muted">
                                    <x-phosphor-pause-fill class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-link-fill class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-pencil-simple-fill
                                        class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-trash-fill class="w-5 h-5 cursor-pointer hover:text-status-paused" />
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-bg-secondary hover:bg-bg-hover transition-colors">
                            <td class="px-4 md:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 xxs:w-10 xxs:h-10 rounded-lg flex-shrink-0">
                                        <img src="{{ asset('assets/images/order.png') }}" alt="Fortnite Logo"
                                            class="w-full h-full rounded-lg object-cover" />
                                    </div>
                                    <div class="min-w-0">
                                        <h3
                                            class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">
                                            Fortnite</h3>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm">10M</td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm hidden sm:table-cell">10K
                            </td>
                            <td
                                class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm whitespace-nowrap hidden lg:table-cell">
                                $6.5 (10k)</td>
                            <td class="px-4 md:px-6 py-4">
                                <span
                                    class="px-2 xxs:px-3 py-1 text-xs font-semibold rounded-full bg-pink-500 text-white whitespace-nowrap inline-block">Active</span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm hidden md:table-cell">45
                                min
                            </td>
                            <td class="px-4 md:px-6 py-3 rounded-r-lg">
                                <div class="flex items-center gap-3 text-text-muted">
                                    <x-phosphor-pause-fill class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-link-fill class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-pencil-simple-fill
                                        class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-trash-fill class="w-5 h-5 cursor-pointer hover:text-status-paused" />
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-bg-primary hover:bg-bg-hover transition-colors">
                            <td class="px-4 md:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 xxs:w-10 xxs:h-10 rounded-lg flex-shrink-0">
                                        <img src="{{ asset('assets/images/order.png') }}" alt="Call of Duty Skin Logo"
                                            class="w-full h-full rounded-lg object-cover" />
                                    </div>
                                    <div class="min-w-0">
                                        <h3
                                            class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">
                                            Call of Duty Skin</h3>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm">20M</td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm hidden sm:table-cell">20K
                            </td>
                            <td
                                class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm whitespace-nowrap hidden lg:table-cell">
                                $9.5 (20k)</td>
                            <td class="px-4 md:px-6 py-4">
                                <span
                                    class="px-2 xxs:px-3 py-1 text-xs font-semibold rounded-full bg-red-500 text-white whitespace-nowrap inline-block">Paused</span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm hidden md:table-cell">1 h
                            </td>
                            <td class="px-4 md:px-6 py-3 rounded-r-lg">
                                <div class="flex items-center gap-3 text-text-muted">
                                    <x-phosphor-play-fill class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-link-fill class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-pencil-simple-fill
                                        class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-trash-fill class="w-5 h-5 cursor-pointer hover:text-status-paused" />
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-bg-secondary hover:bg-bg-hover transition-colors">
                            <td class="px-4 md:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 xxs:w-10 xxs:h-10 rounded-lg flex-shrink-0">
                                        <img src="{{ asset('assets/images/order.png') }}" alt="Apex Legends Logo"
                                            class="w-full h-full rounded-lg object-cover" />
                                    </div>
                                    <div class="min-w-0">
                                        <h3
                                            class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">
                                            Apex Legen...</h3>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm">10M</td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm hidden sm:table-cell">50K
                            </td>
                            <td
                                class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm whitespace-nowrap hidden lg:table-cell">
                                $5.5 (50k)</td>
                            <td class="px-4 md:px-6 py-4">
                                <span
                                    class="px-2 xxs:px-3 py-1 text-xs font-semibold rounded-full bg-red-500 text-white whitespace-nowrap inline-block">Paused</span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm hidden md:table-cell">1 h
                            </td>
                            <td class="px-4 md:px-6 py-3 rounded-r-lg">
                                <div class="flex items-center gap-3 text-text-muted">
                                    <x-phosphor-play-fill class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-link-fill class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-pencil-simple-fill
                                        class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-trash-fill class="w-5 h-5 cursor-pointer hover:text-status-paused" />
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-bg-primary hover:bg-bg-hover transition-colors">
                            <td class="px-4 md:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 xxs:w-10 xxs:h-10 rounded-lg flex-shrink-0">
                                        <img src="{{ asset('assets/images/order.png') }}" alt="Fortnite Logo"
                                            class="w-full h-full rounded-lg object-cover" />
                                    </div>
                                    <div class="min-w-0">
                                        <h3
                                            class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">
                                            Fortnite</h3>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm">2.5B</td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm hidden sm:table-cell">100K
                            </td>
                            <td
                                class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm whitespace-nowrap hidden lg:table-cell">
                                $6.5 (100k)</td>
                            <td class="px-4 md:px-6 py-4">
                                <span
                                    class="px-2 xxs:px-3 py-1 text-xs font-semibold rounded-full bg-red-500 text-white whitespace-nowrap inline-block">Paused</span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm hidden md:table-cell">1 h
                            </td>
                            <td class="px-4 md:px-6 py-3 rounded-r-lg">
                                <div class="flex items-center gap-3 text-text-muted">
                                    <x-phosphor-play-fill class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-link-fill class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-pencil-simple-fill
                                        class="w-5 h-5 cursor-pointer hover:text-text-primary" />
                                    <x-phosphor-trash-fill class="w-5 h-5 cursor-pointer hover:text-status-paused" />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <x-frontend.pagination-ui />

        </div>
    </div>
</div>
