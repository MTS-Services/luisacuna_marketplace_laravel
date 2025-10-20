 <div class="space-y-6">
     <!-- Page Header -->
     <div class="flex items-center justify-between">
         <div>
             <h1 class="text-2xl font-bold text-white">Order/Purchased Orders</h1>
             <p class="text-gray-400 text-sm mt-1">Manage and track your purchased orders</p>
         </div>
         <button
             class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-6 py-2 rounded-lg font-semibold text-sm flex items-center gap-2 transition-all shadow-lg hover:shadow-purple-500/50">
             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
             </svg>
             New Order
         </button>
     </div>

     <!-- Filters -->
     <div class="flex flex-col sm:flex-row gap-4">
         <select
             class="bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-purple-500 transition-all appearance-none cursor-pointer">
             <option value="">All Statuses</option>
             <option value="completed">Completed</option>
             <option value="pending">Pending</option>
             <option value="processing">Processing</option>
         </select>

         <select
             class="bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-purple-500 transition-all appearance-none cursor-pointer">
             <option value="">Recent</option>
             <option value="today">Today</option>
             <option value="week">This Week</option>
             <option value="month">This Month</option>
         </select>
     </div>

     <!-- Orders Table -->
     <div class="overflow-x-auto rounded-lg border border-gray-800">
         <table class="w-full text-left">
             <thead>
                 <tr class="bg-gray-800 border-b border-gray-700">
                     <th class="px-6 py-3 text-sm font-semibold text-gray-400">Order Name</th>
                     <th class="px-6 py-3 text-sm font-semibold text-gray-400">Type</th>
                     <th class="px-6 py-3 text-sm font-semibold text-gray-400">Seller</th>
                     <th class="px-6 py-3 text-sm font-semibold text-gray-400">Ordered Date</th>
                     <th class="px-6 py-3 text-sm font-semibold text-gray-400">Order Status</th>
                     <th class="px-6 py-3 text-sm font-semibold text-gray-400">Quantity</th>
                     <th class="px-6 py-3 text-sm font-semibold text-gray-400">Price ($)</th>
                 </tr>
             </thead>
             <tbody class="divide-y divide-gray-800">
                 <!-- Row 1 -->
                 <tr class="hover:bg-gray-800/50 transition-colors">
                     <td class="px-6 py-4">
                         <div class="flex items-center gap-3">
                             <div
                                 class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                 F</div>
                             <div>
                                 <h3 class="font-semibold text-white text-sm">Fresh Apples</h3>
                                 <p class="text-gray-400 text-xs">Discount: 10%</p>
                                 <a href="#" class="text-purple-400 text-xs hover:underline">Learn more →</a>
                             </div>
                         </div>
                     </td>
                     <td class="px-6 py-4 text-gray-300 text-sm">Fruit</td>
                     <td class="px-6 py-4 text-gray-300 text-sm">Nature's Farm</td>
                     <td class="px-6 py-4 text-gray-400 text-sm">2025-10-18</td>
                     <td class="px-6 py-4">
                         <span
                             class="px-3 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400">Completed</span>
                     </td>
                     <td class="px-6 py-4 text-gray-300 text-sm">15</td>
                     <td class="px-6 py-4 text-gray-300 font-semibold text-sm">$45.00</td>
                 </tr>

                 <!-- Row 2 -->
                 <tr class="hover:bg-gray-800/50 transition-colors">
                     <td class="px-6 py-4">
                         <div class="flex items-center gap-3">
                             <div
                                 class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                 B</div>
                             <div>
                                 <h3 class="font-semibold text-white text-sm">Banana Pack</h3>
                                 <p class="text-gray-400 text-xs">Discount: 5%</p>
                                 <a href="#" class="text-purple-400 text-xs hover:underline">Learn more →</a>
                             </div>
                         </div>
                     </td>
                     <td class="px-6 py-4 text-gray-300 text-sm">Fruit</td>
                     <td class="px-6 py-4 text-gray-300 text-sm">Tropical Goods</td>
                     <td class="px-6 py-4 text-gray-400 text-sm">2025-10-19</td>
                     <td class="px-6 py-4">
                         <span
                             class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400">Pending</span>
                     </td>
                     <td class="px-6 py-4 text-gray-300 text-sm">8</td>
                     <td class="px-6 py-4 text-gray-300 font-semibold text-sm">$24.00</td>
                 </tr>

                 <!-- Row 3 -->
                 <tr class="hover:bg-gray-800/50 transition-colors">
                     <td class="px-6 py-4">
                         <div class="flex items-center gap-3">
                             <div
                                 class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                 M</div>
                             <div>
                                 <h3 class="font-semibold text-white text-sm">Milk Carton</h3>
                                 <p class="text-gray-400 text-xs">Discount: 0%</p>
                                 <a href="#" class="text-purple-400 text-xs hover:underline">Learn more →</a>
                             </div>
                         </div>
                     </td>
                     <td class="px-6 py-4 text-gray-300 text-sm">Dairy</td>
                     <td class="px-6 py-4 text-gray-300 text-sm">Happy Cow</td>
                     <td class="px-6 py-4 text-gray-400 text-sm">2025-10-20</td>
                     <td class="px-6 py-4">
                         <span
                             class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-500/20 text-blue-400">Processing</span>
                     </td>
                     <td class="px-6 py-4 text-gray-300 text-sm">5</td>
                     <td class="px-6 py-4 text-gray-300 font-semibold text-sm">$12.50</td>
                 </tr>
             </tbody>
         </table>
     </div>

     <!-- Pagination -->
     <div class="flex items-center justify-between">
         <div class="text-sm text-gray-400">
             Showing 1 to 3 of 3 results
         </div>
         <div class="flex gap-2">
             <button
                 class="px-4 py-2 bg-gray-800 text-gray-400 rounded-lg text-sm hover:bg-gray-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                 disabled>Previous</button>
             <button
                 class="px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg text-sm font-semibold hover:from-purple-700 hover:to-purple-800 transition-all">1</button>
             <button
                 class="px-4 py-2 bg-gray-800 text-gray-400 rounded-lg text-sm hover:bg-gray-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                 disabled>Next</button>
         </div>
     </div>
 </div>
