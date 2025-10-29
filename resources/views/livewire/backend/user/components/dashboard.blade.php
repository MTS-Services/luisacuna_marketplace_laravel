<div class="space-y-6">
    <!-- Filters -->
    <div class="flex flex-col sm:flex-row gap-4">
        <div class="relative" id="dropdown-wrapper">
            <select id="status-select"
                class="bg-gray-900 border text-base border-purple-700 w-full sm:w-70 text-gray-300 rounded-lg pl-4 pr-10 py-1 focus:outline-none focus:border-purple-500 transition-all appearance-none cursor-pointer">
                <option value="">All statuses</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
            </select>
            <div id="icon-container" class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                <flux:icon name="chevron-down" class="w-4 h-4 text-gray-300" stroke="white" />
            </div>
        </div>

        <div class="relative">
            <select
                class="bg-gray-900 border border-purple-700 w-full sm:w-70 text-gray-300 rounded-lg pl-4 pr-10 py-1 text-base focus:outline-none focus:border-purple-500 transition-all appearance-none cursor-pointer">
                <option value="">Recent</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                <flux:icon name="chevron-down" class="w-4 h-4 text-gray-300" stroke="white" />
            </div>
        </div>
    </div>

    <div>
        <div class="overflow-x-auto shadow-2xl">
            <table class="w-full text-left table-auto border-separate border-spacing-0">
                <thead>
                    <tr class=" text-sm text-zinc-100 uppercase tracking-wider">
                        <th
                            class="px-4 md:px-6 py-5 text-sm md:text-base text-zinc-50 capitalize font-normal flex items-center gap-1">
                            Order Name
                            <span>
                                <img src="{{ asset('assets/icons/ic_round-arrow-left.png') }}" class="w-full h-full"
                                    alt="">
                            </span>
                        </th>
                        <th class="px-4 md:px-6 py-5 text-sm md:text-base text-zinc-50 capitalize font-normal">Type</th>
                        <th class="px-4 md:px-6 py-5 text-sm md:text-base text-zinc-50 capitalize font-normal">Seller
                        </th>
                        <th
                            class="px-4 md:px-6 py-5 text-sm md:text-base text-zinc-50 capitalize font-normal whitespace-nowrap">
                            Ordered date</th>
                        <th
                            class="px-4 md:px-6 py-5 text-sm md:text-base text-zinc-50 capitalize font-normal whitespace-nowrap">
                            Order status</th>
                        <th class="px-4 md:px-6 py-5 text-sm md:text-base text-zinc-50 capitalize font-normal">Quantity
                        </th>
                        <th class="px-4 md:px-6 py-5 text-sm md:text-base text-zinc-50 capitalize font-normal">Price ($)
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    <tr class="bg-zinc-800 hover:bg-zinc-700 transition-colors">
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-orange-600 flex-shrink-0">
                                    <img src="{{ asset('assets/images/order.png') }}" alt="Fortnite Logo"
                                        class="w-full h-full rounded-lg" />
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-zinc-50 text-sm md:text-base">Fortnite VB Skin Gift
                                    </h3>
                                    <p class="text-xs text-green-400 truncate">Cheapest +75% Discount</p>
                                    <a href="#"
                                        class="text-pink-400 text-xs hover:underline flex items-center gap-1">Learn
                                        more →</a>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Items</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Albert Flores</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm whitespace-nowrap">February 11, 2014</td>
                        <td class="px-4 md:px-6 py-4">
                            <span
                                class="px-3 py-1 text-xs font-semibold rounded-full bg-pink-500 text-white whitespace-nowrap inline-block">Completed</span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">7421</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-50 font-semibold text-sm">$4.75</td>
                    </tr>

                    <tr class="bg-zinc-950 hover:bg-zinc-700 transition-colors">
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-orange-600 flex-shrink-0">
                                    <img src="{{ asset('assets/images/order.png') }}" alt="Fortnite Logo"
                                        class="w-full h-full rounded-lg" />
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-zinc-50 text-sm md:text-base">Fortnite VB Skin Gift
                                    </h3>
                                    <p class="text-xs text-green-400 truncate">Cheapest +75% Discount</p>
                                    <a href="#"
                                        class="text-pink-400 text-xs hover:underline flex items-center gap-1">Learn
                                        more →</a>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Items</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Jenny Wilson</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm whitespace-nowrap">February 28, 2018</td>
                        <td class="px-4 md:px-6 py-4">
                            <span
                                class="px-3 py-1 text-xs font-semibold rounded-full bg-pink-500 text-white whitespace-nowrap inline-block">Completed</span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">5832</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-50 font-semibold text-sm">$15.30</td>
                    </tr>

                </tbody>
            </table>
        </div>

       <x-frontend.pagination-ui />
    </div>
</div>
