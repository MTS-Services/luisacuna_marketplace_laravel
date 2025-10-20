
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">Order/Purchased Orders</h1>
                <p class="text-gray-400 text-sm mt-1">Manage and track your purchased orders</p>
            </div>
            <button class="btn-primary flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                New Order
            </button>
        </div>

        <!-- Filters -->
        <div class="flex flex-col sm:flex-row gap-4">
            <select name="status"
                class="filter-dropdown flex-1 sm:flex-initial bg-gray-900 text-gray-300 border border-gray-700 rounded-md p-2">
                <option value="">All Statuses</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
            </select>

            <select name="recent"
                class="filter-dropdown flex-1 sm:flex-initial bg-gray-900 text-gray-300 border border-gray-700 rounded-md p-2">
                <option value="">Recent</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
            </select>
        </div>

        <!-- Orders Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900 text-gray-400">
                        <th class="p-3">Order Name</th>
                        <th class="p-3">Type</th>
                        <th class="p-3">Seller</th>
                        <th class="p-3">Ordered Date</th>
                        <th class="p-3">Order Status</th>
                        <th class="p-3">Quantity</th>
                        <th class="p-3">Price ($)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    <tr class="hover:bg-gray-800">
                        <td class="p-3">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                                    F</div>
                                <div>
                                    <h3 class="font-semibold text-white">Fresh Apples</h3>
                                    <p class="text-gray-400 text-sm">Discount: 10%</p>
                                    <a href="#" class="text-indigo-400 text-sm hover:underline">Learn more →</a>
                                </div>
                            </div>
                        </td>
                        <td class="p-3 text-gray-300">Fruit</td>
                        <td class="p-3 text-gray-300">Nature's Farm</td>
                        <td class="p-3 text-gray-400">2025-10-18</td>
                        <td class="p-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-600/20 text-green-400">Completed</span>
                        </td>
                        <td class="p-3 text-gray-300">15</td>
                        <td class="p-3 text-gray-300 font-semibold">$45.00</td>
                    </tr>

                    <tr class="hover:bg-gray-800">
                        <td class="p-3">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center text-white font-bold">
                                    B</div>
                                <div>
                                    <h3 class="font-semibold text-white">Banana Pack</h3>
                                    <p class="text-gray-400 text-sm">Discount: 5%</p>
                                    <a href="#" class="text-indigo-400 text-sm hover:underline">Learn more →</a>
                                </div>
                            </div>
                        </td>
                        <td class="p-3 text-gray-300">Fruit</td>
                        <td class="p-3 text-gray-300">Tropical Goods</td>
                        <td class="p-3 text-gray-400">2025-10-19</td>
                        <td class="p-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-600/20 text-yellow-400">Pending</span>
                        </td>
                        <td class="p-3 text-gray-300">8</td>
                        <td class="p-3 text-gray-300 font-semibold">$24.00</td>
                    </tr>

                    <tr class="hover:bg-gray-800">
                        <td class="p-3">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                    M</div>
                                <div>
                                    <h3 class="font-semibold text-white">Milk Carton</h3>
                                    <p class="text-gray-400 text-sm">Discount: 0%</p>
                                    <a href="#" class="text-indigo-400 text-sm hover:underline">Learn more →</a>
                                </div>
                            </div>
                        </td>
                        <td class="p-3 text-gray-300">Dairy</td>
                        <td class="p-3 text-gray-300">Happy Cow</td>
                        <td class="p-3 text-gray-400">2025-10-20</td>
                        <td class="p-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-600/20 text-blue-400">Processing</span>
                        </td>
                        <td class="p-3 text-gray-300">5</td>
                        <td class="p-3 text-gray-300 font-semibold">$12.50</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div class="text-sm text-gray-400">
                Showing 1 to 3 of 3 results
            </div>
            <div class="flex space-x-2">
                <button class="px-3 py-1 bg-gray-800 text-gray-400 rounded-md" disabled>Previous</button>
                <button class="px-3 py-1 bg-indigo-600 text-white rounded-md">1</button>
                <button class="px-3 py-1 bg-gray-800 text-gray-400 rounded-md" disabled>Next</button>
            </div>
        </div>
    </div>
