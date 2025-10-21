 <div class="space-y-6">
     <!-- Filters -->
     <div class="flex flex-col sm:flex-row gap-4">
         <div class="relative" id="dropdown-wrapper">
             <select id="status-select"
                 class="bg-gray-900 border text-base border-purple-700 w-70 text-gray-300 rounded-lg pl-4 pr-10 py-1  focus:outline-none focus:border-purple-500 transition-all appearance-none cursor-pointer">
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
                 class="bg-gray-900 border border-purple-700 w-70 text-gray-300 rounded-lg pl-4 pr-10 py-1 text-base focus:outline-none focus:border-purple-500 transition-all appearance-none cursor-pointer">
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

     <div class="bg-[#120a2e] min-h-screen font-sans">

         <div class="overflow-x-auto  shadow-2xl">
             <table class="w-full text-left table-auto border-separate border-spacing-0">
                 <thead>
                     <tr class="bg-[#1B0C33] text-sm text-gray-400 uppercase tracking-wider">
                         <th class="px-6 py-5 text-base text-gray-100 capitalize font-normal flex items-center gap-1">
                             Order Name
                             <span>
                                <img src="{{ asset('assets/icons/ic_round-arrow-left.png') }}" class="w-full h-full" alt="">
                             </span>
                         </th>
                         <th class="px-6 py-5 text-base text-gray-100 capitalize font-normal">Type</th>
                         <th class="px-6 py-5 text-base text-gray-100 capitalize font-normal">Seller</th>
                         <th class="px-6 py-5 text-base text-gray-100 capitalize font-normal">Ordered date</th>
                         <th class="px-6 py-5 text-base text-gray-100 capitalize font-normal">Order status</th>
                         <th class="px-6 py-5 text-base text-gray-100 capitalize font-normal">Quantity</th>
                         <th class="px-6 py-5 text-base text-gray-100 capitalize font-normal">Price ($)</th>
                     </tr>
                 </thead>
                 <tbody class="divide-y divide-[#321c62]">
                     <tr class="bg-[#351966] hover:bg-[#321c62] transition-colors">
                         <td class="px-6 py-4">
                             <div class="flex items-center gap-3">
                                 <img src="fortnite-logo.png" alt="Fortnite Logo"
                                     class="w-10 h-10 rounded-lg bg-orange-600 p-1" />
                                 <div>
                                     <h3 class="font-semibold text-white text-base">Fortnite VB Skin Gift</h3>
                                     <p class="text-xs text-green-400">Cheapest +75% Discount</p>
                                     <a href="#"
                                         class="text-purple-400 text-xs hover:underline flex items-center gap-1">Learn
                                         more →</a>
                                 </div>
                             </div>
                         </td>
                         <td class="px-6 py-4 text-gray-300 text-sm">Items</td>
                         <td class="px-6 py-4 text-gray-300 text-sm">Albert Flores</td>
                         <td class="px-6 py-4 text-gray-400 text-sm">February 11, 2014</td>
                         <td class="px-6 py-4">
                             <span
                                 class="px-3 py-1 text-xs font-semibold rounded-full bg-pink-600 text-white">Completed</span>
                         </td>
                         <td class="px-6 py-4 text-gray-300 text-sm">7421</td>
                         <td class="px-6 py-4 text-white font-semibold text-sm">$4.75</td>
                     </tr>

                     <tr class="bg-[#1B0C33] hover:bg-[#321c62] transition-colors">
                         <td class="px-6 py-4">
                             <div class="flex items-center gap-3">
                                 <img src="fortnite-logo.png" alt="Fortnite Logo"
                                     class="w-10 h-10 rounded-lg bg-orange-600 p-1" />
                                 <div>
                                     <h3 class="font-semibold text-white text-base">Fortnite VB Skin Gift</h3>
                                     <p class="text-xs text-green-400">Cheapest +75% Discount</p>
                                     <a href="#"
                                         class="text-purple-400 text-xs hover:underline flex items-center gap-1">Learn
                                         more →</a>
                                 </div>
                             </div>
                         </td>
                         <td class="px-6 py-4 text-gray-300 text-sm">Items</td>
                         <td class="px-6 py-4 text-gray-300 text-sm">Jenny Wilson</td>
                         <td class="px-6 py-4 text-gray-400 text-sm">February 28, 2018</td>
                         <td class="px-6 py-4">
                             <span
                                 class="px-3 py-1 text-xs font-semibold rounded-full bg-pink-600 text-white">Completed</span>
                         </td>
                         <td class="px-6 py-4 text-gray-300 text-sm">5832</td>
                         <td class="px-6 py-4 text-white font-semibold text-sm">$15.30</td>
                     </tr>

                     <tr class="bg-[#351966] hover:bg-[#321c62] transition-colors">
                         <td class="px-6 py-4">
                             <div class="flex items-center gap-3">
                                 <img src="fortnite-logo.png" alt="Fortnite Logo"
                                     class="w-10 h-10 rounded-lg bg-orange-600 p-1" />
                                 <div>
                                     <h3 class="font-semibold text-white text-base">Fortnite VB Skin Gift</h3>
                                     <p class="text-xs text-green-400">Cheapest +75% Discount</p>
                                     <a href="#"
                                         class="text-purple-400 text-xs hover:underline flex items-center gap-1">Learn
                                         more →</a>
                                 </div>
                             </div>
                         </td>
                         <td class="px-6 py-4 text-gray-300 text-sm">Items</td>
                         <td class="px-6 py-4 text-gray-300 text-sm">Ralph Edwards</td>
                         <td class="px-6 py-4 text-gray-400 text-sm">May 20, 2015</td>
                         <td class="px-6 py-4">
                             <span
                                 class="px-3 py-1 text-xs font-semibold rounded-full bg-pink-600 text-white">Completed</span>
                         </td>
                         <td class="px-6 py-4 text-gray-300 text-sm">6190</td>
                         <td class="px-6 py-4 text-white font-semibold text-sm">$10.25</td>
                     </tr>

                     <tr class="bg-[#1B0C33] hover:bg-[#321c62] transition-colors">
                         <td class="px-6 py-4">
                             <div class="flex items-center gap-3">
                                 <img src="fortnite-logo.png" alt="Fortnite Logo"
                                     class="w-10 h-10 rounded-lg bg-orange-600 p-1" />
                                 <div>
                                     <h3 class="font-semibold text-white text-base">Fortnite VB Skin Gift</h3>
                                     <p class="text-xs text-green-400">Cheapest +75% Discount</p>
                                     <a href="#"
                                         class="text-purple-400 text-xs hover:underline flex items-center gap-1">Learn
                                         more →</a>
                                 </div>
                             </div>
                         </td>
                         <td class="px-6 py-4 text-gray-300 text-sm">Items</td>
                         <td class="px-6 py-4 text-gray-300 text-sm">Theresa Webb</td>
                         <td class="px-6 py-4 text-gray-400 text-sm">May 29, 2017</td>
                         <td class="px-6 py-4">
                             <span
                                 class="px-3 py-1 text-xs font-semibold rounded-full bg-pink-600 text-white">Completed</span>
                         </td>
                         <td class="px-6 py-4 text-gray-300 text-sm">8347</td>
                         <td class="px-6 py-4 text-white font-semibold text-sm">$13.60</td>
                     </tr>

                     <tr class="bg-[#351966] hover:bg-[#321c62] transition-colors">
                         <td class="px-6 py-4">
                             <div class="flex items-center gap-3">
                                 <img src="fortnite-logo.png" alt="Fortnite Logo"
                                     class="w-10 h-10 rounded-lg bg-orange-600 p-1" />
                                 <div>
                                     <h3 class="font-semibold text-white text-base">Fortnite VB Skin Gift</h3>
                                     <p class="text-xs text-green-400">Cheapest +75% Discount</p>
                                     <a href="#"
                                         class="text-purple-400 text-xs hover:underline flex items-center gap-1">Learn
                                         more →</a>
                                 </div>
                             </div>
                         </td>
                         <td class="px-6 py-4 text-gray-300 text-sm">Items</td>
                         <td class="px-6 py-4 text-gray-300 text-sm">Marvin McKinney</td>
                         <td class="px-6 py-4 text-gray-400 text-sm">December 29, 2012</td>
                         <td class="px-6 py-4">
                             <span
                                 class="px-3 py-1 text-xs font-semibold rounded-full bg-pink-600 text-white">Completed</span>
                         </td>
                         <td class="px-6 py-4 text-gray-300 text-sm">7210</td>
                         <td class="px-6 py-4 text-white font-semibold text-sm">$7.99</td>
                     </tr>

                     <tr class="bg-[#1B0C33] hover:bg-[#321c62] transition-colors">
                         <td class="px-6 py-4">
                             <div class="flex items-center gap-3">
                                 <img src="apex-logo.png" alt="Apex Legends Logo"
                                     class="w-10 h-10 rounded-full bg-[#1e133c] border border-gray-700 p-1" />
                                 <div>
                                     <h3 class="font-semibold text-white text-base">Apex Legends Batt...</h3>
                                     <p class="text-xs text-red-400">Exclusive +60% Off</p>
                                     <a href="#"
                                         class="text-purple-400 text-xs hover:underline flex items-center gap-1">Discover
                                         more →</a>
                                 </div>
                             </div>
                         </td>
                         <td class="px-6 py-4 text-gray-300 text-sm">Passes</td>
                         <td class="px-6 py-4 text-gray-300 text-sm">Lara Croft</td>
                         <td class="px-6 py-4 text-gray-400 text-sm">January 15, 2019</td>
                         <td class="px-6 py-4">
                             <span class="px-3 py-1 text-xs font-semibold rounded-full bg-[#321c62] text-red-400">In
                                 Progress</span>
                         </td>
                         <td class="px-6 py-4 text-gray-300 text-sm">11567</td>
                         <td class="px-6 py-4 text-white font-semibold text-sm">$8.50</td>
                     </tr>

                     <tr class="bg-[#351966] hover:bg-[#321c62] transition-colors">
                         <td class="px-6 py-4">
                             <div class="flex items-center gap-3">
                                 <img src="cod-logo.png" alt="Call of Duty Logo"
                                     class="w-10 h-10 rounded-full bg-gray-900 border border-gray-700 p-1" />
                                 <div>
                                     <h3 class="font-semibold text-white text-base">Call of Duty Skin P...</h3>
                                     <p class="text-xs text-purple-400">Limited Time +50% Savi...</p>
                                     <a href="#"
                                         class="text-purple-400 text-xs hover:underline flex items-center gap-1">View
                                         details →</a>
                                 </div>
                             </div>
                         </td>
                         <td class="px-6 py-4 text-gray-300 text-sm">Bundles</td>
                         <td class="px-6 py-4 text-gray-300 text-sm">John Doe</td>
                         <td class="px-6 py-4 text-gray-400 text-sm">March 10, 2026</td>
                         <td class="px-6 py-4">
                             <span
                                 class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-800 text-indigo-400">Pending</span>
                         </td>
                         <td class="px-6 py-4 text-gray-300 text-sm">3024</td>
                         <td class="px-6 py-4 text-white font-semibold text-sm">$11.75</td>
                     </tr>
                 </tbody>
             </table>
         </div>

         <div class="flex items-center justify-end mt-4 text-sm gap-2">
             <button
                 class="px-4 py-2 bg-[#351966] text-gray-400 rounded-lg text-sm hover:bg-[#321c62] transition-colors disabled:opacity-50 disabled:cursor-not-allowed">Previous</button>
             <button
                 class="px-4 py-2 bg-purple-700 text-white rounded-lg text-sm font-semibold shadow-lg shadow-purple-900/50 hover:bg-purple-600 transition-colors">1</button>
             <button
                 class="px-4 py-2 bg-[#351966] text-gray-400 rounded-lg text-sm hover:bg-[#321c62] transition-colors">2</button>
             <button
                 class="px-4 py-2 bg-[#351966] text-gray-400 rounded-lg text-sm hover:bg-[#321c62] transition-colors">3</button>
             <button
                 class="px-4 py-2 bg-[#351966] text-gray-400 rounded-lg text-sm hover:bg-[#321c62] transition-colors">4</button>
             <button
                 class="px-4 py-2 bg-[#351966] text-gray-400 rounded-lg text-sm hover:bg-[#321c62] transition-colors">5</button>
             <button
                 class="px-4 py-2 bg-[#351966] text-gray-400 rounded-lg text-sm hover:bg-[#321c62] transition-colors">Next</button>
         </div>
     </div>
 </div>
