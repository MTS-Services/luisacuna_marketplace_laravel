 <div>
     <div class=" flex items-center justify-center p-12 ">
         <div class="w-full max-w-6xl ">
             <!-- Breadcrumb -->
             <div class="flex items-center gap-2 mb-8 text-lg">
                 <span class="text-text-primary">
                     <span class=" text-text-primary">Home</span>
                     <span class=" text-text-primary">></span>
                     <span class=" text-text-primary">Item details</span>
                     <span class=" text-text-primary">></span>
                     <span class=" text-text-primary">Item delivery and price</span>
                 </span>
             </div>

             <!-- Header -->
             <div class="text-center mb-12">
                 <h1 class="text-5xl text-text-white mb-8">Sell Game Currency</h1>
                 <!-- Game Badge -->
                 <div class="flex items-center justify-center gap-3    w-fit mx-auto px-6 py-3 rounded-full      ">
                     <img src="{{ asset('assets/images/game_icon/8ball.png') }}" alt="">
                     <div class="font-medium text-text-wite text-xl">
                         8
                     </div>
                     <span class="text-text-white text-lg">Ball Pool</span>
                 </div>
             </div>

             <!-- Main Card -->
             <div class=" bg-bg-primary rounded-2xl p-18 shadow-2xl">

                 <!-- Offer Title Section -->
                 <div class="mb-8">
                     <label class="text-text-white text-3xl mb-4 block">Offer Title</label>
                     <div
                         class="h-1 border-b border-purple-500/50 w-full bg-gradient-to-br from-transparent  to-transparent rounded-full mb-6">
                     </div>

                     <!-- Character Counter -->
                     <div class="text-right text-text-white text-sm mb-3 font-medium">0/200</div>

                     <!-- Input Field -->
                     <textarea placeholder="Type here......" maxlength="300"
                         class="w-full bg-bg-secondary  border-purple-500/30 rounded-xl p-4 dark:placeholder-white placeholder-opacity-100 focus:outline-none focus:border-purple-400/60 focus:ring-2 focus:ring-purple-500/20 transition-all resize-none h-24 text-xl"
                         spellcheck="false"
                         aria-label="To enrich screen reader interactions, please activate Accessibility in Grammarly extension settings"></textarea>
                 </div>

                 <!-- Description -->
                 <div class="">
                     <p class="text-text-white leading-relaxed text-lg">
                         Provide a descriptive title for your product. Consider the keywords buyers might use to find
                         it. Place the most searchable words at the beginning of your title. The title must not exceed
                         160 characters.
                     </p>
                 </div>
             </div>
         </div>
     </div>

     <div class=" flex items-center justify-center p-12 ">

         <div class="w-full max-w-6xl">
             <!-- Main Card -->
             <div class=" bg-bg-primary rounded-2xl p-18 shadow-2xl">
                 <!-- Offer Title Section -->
                 <div class="mb-8">
                     <label class="text-text-white text-3xl mb-4 block border-b border-purple-500/50 py-4">Upload offer
                         images</label>
                     <div class="w-full max-w-4xl ">
                         <!-- Uploaded images -->
                         <div class="flex flex-wrap gap-4 mb-8">
                             <div class="relative w-24 h-24 rounded-lg overflow-hidden">
                                 <img src="{{ asset('assets/images/game_icon/8ball1.jpg') }}"
                                     class="w-full h-full object-cover">
                                 <button
                                     class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">×</button>
                             </div>

                             <div class="relative w-24 h-24 rounded-lg overflow-hidden">
                                 <img src="{{ asset('assets/images/game_icon/8ball2.jpg') }}"
                                     class="w-full h-full object-cover">
                                 <button
                                     class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">×</button>
                             </div>

                             <div class="relative w-24 h-24 rounded-lg overflow-hidden">
                                 <img src="{{ asset('assets/images/game_icon/8ball3.png') }}"
                                     class="w-full h-full object-cover">
                                 <button
                                     class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">×</button>
                             </div>

                             <div class="relative w-24 h-24 rounded-lg overflow-hidden">
                                 <img src="{{ asset('assets/images/game_icon/8ball4.png') }}"
                                     class="w-full h-full object-cover">
                                 <button
                                     class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">×</button>
                             </div>
                         </div>

                         <!-- Upload button -->
                         <div class="flex justify-left mb-6">
                             <button
                                 class="bg-purple-600 hover:bg-purple-700 text-white font-medium px-6 py-3 rounded-full transition">
                                 Upload images
                             </button>
                         </div>

                         <!-- Note -->
                         <p class="text-left text-text-white text-lg">
                             Must be JPEG, PNG or HEIC and cannot exceed 10MB.
                         </p>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <div class=" flex items-center justify-center p-12 ">
         <div class="w-full max-w-6xl ">

             <!-- Main Card -->
             <div class=" bg-bg-primary rounded-2xl p-18 shadow-2xl">

                 <!-- Offer Title Section -->
                 <div class="mb-8">
                     <label class="text-text-white text-3xl mb-4 block">Description (Optional)</label>
                     <div
                         class="h-1 border-b border-purple-500/50 w-full bg-gradient-to-br from-transparent  to-transparent rounded-full mb-6">
                         <div class="text-right text-text-white text-sm mb-3 pt-2 font-medium">Step 1/3</div>
                     </div>

                     <!-- Character Counter -->
                     <div class="text-right text-text-white text-sm mb-3 pt-4 font-medium">0/200</div>

                     <!-- Input Field -->
                     <textarea placeholder="Type here......" maxlength="300"
                         class="w-full bg-bg-secondary  border-purple-500/30 rounded-xl p-4 dark:placeholder-white placeholder-opacity-100 focus:outline-none focus:border-purple-400/60 focus:ring-2 focus:ring-purple-500/20 transition-all resize-none h-24 text-xl"></textarea>
                 </div>

                 <!-- Description -->
                 <div class="">
                     <p class="text-text-white leading-relaxed text-lg">
                         The listing title and description must be accurate and as informative as possible (no random or
                         lottery). Misleading description is a violation of our <span class="text-[#FF2E91]">Seller
                             Rules</span>.
                     </p>
                 </div>
             </div>
         </div>
     </div>

     <div class=" flex items-center justify-center p-12 ">
         <div class="w-full max-w-6xl ">

             <!-- Main Card -->
             <div class=" bg-bg-primary rounded-2xl p-18 shadow-2xl">

                 <!-- Offer Title Section -->
                 <div class="mb-8">
                     <label class="text-text-white text-3xl mb-4 block">Delivery</label>
                     <div
                         class="h-1 border-b border-purple-500/50 w-full bg-gradient-to-br from-transparent  to-transparent rounded-full mb-6">

                     </div>

                     <!-- Radio Options -->
                     <div class="space-y-4 mb-8">
                         <label class="flex items-center cursor-pointer group">
                             <input type="radio" name="delivery" value="manual" checked
                                 class="w-5 h-5 accent-[#FF2E91]">
                             <span
                                 class="ml-3 text-text-white text-lg group-hover:text-gray-200 transition">Manual</span>
                         </label>
                         <label class="flex items-center cursor-pointer group">
                             <input type="radio" name="delivery" value="auto" class="w-5 h-5 accent-[#FF2E91]">
                             <span class="ml-3 text-text-white text-lg group-hover:text-gray-200 transition">Auto</span>
                         </label>
                     </div>

                     <!-- Guaranteed Delivery Time Section -->
                     <div class="space-y-4">
                         <label class="block text-text-white text-lg font-medium">
                             Guaranteed Delivery Time:
                         </label>

                         <select
                             class="w-full bg-bg-secondary text-text-white  rounded px-4 py-3 focus:outline-none focus:border-[#FF2E91] focus:ring-1 focus:ring-[#FF2E91] transition appearance-none cursor-pointer">

                             <option value="#" class="text-text-white">Choose </option>
                             <option value="24h">24 Hours</option>
                             <option value="48h">48 Hours</option>
                             <option value="72h">72 Hours</option>
                         </select>

                         <!-- Helper Text -->
                         <p class="text-gray-100 text-lg mt-4">
                             Faster delivery time improves your offer's ranking in the offer list.
                         </p>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     {{-- <div class="p-6">
         <div class="max-w-6xl mx-auto">
             <!-- Main Container -->
             <div class="bg-bg-primary rounded-3xl p-8 md:p-12">
                 <!-- Title -->
                 <h1 class="text-3xl md:text-4xl font-light text-text-white mb-2">Account information shared with buyer
                 </h1>
                 <div class="h-px bg-gradient-to-r from-purple-400 to-transparent mb-8"></div>

                 <!-- Description -->
                 <p class="text-text-gray-200 text-lg leading-relaxed mb-6">
                     You should provide all the details related to the account that might be relevant to have the full
                     ownership of the account. This includes:
                 </p>

                 <!-- Bullet List -->
                 <ul class="space-y-2 mb-8 ml-4">
                     <li class="text-gray-300 flex items-start">
                         <span class="mr-3">•</span>
                         <span>Character name</span>
                     </li>
                     <li class="text-gray-300 flex items-start">
                         <span class="mr-3">•</span>
                         <span>Login name</span>
                     </li>
                     <li class="text-gray-300 flex items-start">
                         <span class="mr-3">•</span>
                         <span>Password</span>
                     </li>
                     <li class="text-gray-300 flex items-start">
                         <span class="mr-3">•</span>
                         <span>Security questions and answers</span>
                     </li>
                     <li class="text-gray-300 flex items-start">
                         <span class="mr-3">•</span>
                         <span>Any extra passwords/PIN/codes if applicable</span>
                     </li>
                     <li class="text-gray-300 flex items-start">
                         <span class="mr-3">•</span>
                         <span>Any other relevant info</span>
                     </li>
                 </ul>

                 <!-- Account Button -->
                 <button
                     class="w-full bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold py-4 px-6 rounded-2xl mb-6 transition-all duration-200 text-lg text-left">
                     Account 1
                 </button>

                 <!-- Character Counter -->
                     <div class="text-right text-text-white text-sm mb-3 pt-4 font-medium">0/500</div>

                 <!-- Text Area Container -->
                 <div class="relative">

                     <textarea placeholder="Type here......" maxlength="300"
                         class="w-full bg-bg-secondary  border-purple-500/30 rounded-xl p-4 dark:placeholder-white placeholder-opacity-100 focus:outline-none focus:border-purple-400/60 focus:ring-2 focus:ring-purple-500/20 transition-all resize-none h-24 text-xl"
                         spellcheck="false"
                         aria-label="To enrich screen reader interactions, please activate Accessibility in Grammarly extension settings"></textarea>

                 </div>
             </div>
         </div>

         <div class="  p-8 ">
             <div class="bg-bg-primary max-w-6xl mx-auto rounded-2xl">
                 <!-- Quantity Section -->
                 <div class="bg-bg-primary backdrop-blur-sm rounded-2xl p-8 mb-0  ">
                     <h2 class="text-3xl font-light text-text-white mb-6 pb-4 border-b border-purple-500/50">Quantity
                     </h2>

                     <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                         <!-- Total Quantity -->
                         <div>
                             <label class="text-text-white text-lg mb-3 block">Total Quantity available:</label>
                             <div
                                 class="bg-bg-secondary rounded-lg px-6 py-4 text-text-white text-center border border-purple-800/30">
                                 10 Unit
                             </div>
                         </div>

                         <!-- Minimum Offer Quantity -->
                         <div>
                             <label class="text-text-white text-lg mb-3 block">Minimum Offer quantity:</label>
                             <div
                                 class="bg-bg-secondary rounded-lg px-6 py-4 text-text-white text-center border border-purple-800/30">
                                 1 Unit
                             </div>
                         </div>
                     </div>
                 </div>

                 <!-- Price Section -->
                 <div class="bg-bg-primary rounded-2xl p-12  ">
                     <h2 class="text-3xl font-light text-text-white mb-6 pb-4 border-b border-purple-500/50">Price</h2>

                     <!-- Price per Account -->
                     <div class="mb-6">
                         <label class="text-text-white text-lg mb-3 block">Price per account:</label>
                         <div class="flex gap-3">
                             <input type="text" placeholder="Price"
                                 class="flex-1 bg-bg-secondary border border-purple-800/30 rounded-lg px-6 py-4 text-text-white placeholder-gray-400 focus:outline-none focus:border-purple-500/50">
                             <button class="bg-[#853EFF] text-text-white  px-6 py-4 rounded-lg transition-colors">
                                 USD
                             </button>
                         </div>
                     </div>

                     <!-- Helper Text -->
                     <p class="text-text-white text-sm">Competitive prices improve your offer's ranking in the offer
                         list.
                     </p>
                 </div>
             </div>
         </div>

         <div class="pb-8">
             <div class="max-w-6xl mx-auto">
                 <!-- Fee Structure Card -->
                 <div class="bg-gradient-to-br bg-bg-primary rounded-3xl p-8 mb-8">
                     <h2 class="text-3xl font-light text-text-white mb-6 pb-4 border-b border-purple-500">
                         Fee structure
                     </h2>

                     <div class="space-y-6">
                         <div>
                             <p class="text-text-white">
                                 Flat fee (per purchase): <span class="text-text-white font-semibold">$0.00 USD</span>
                             </p>
                         </div>

                         <div>
                             <p class="text-text-white">
                                 Percentage fee (per purchase): <span class="text-text-white font-semibold">5 % of
                                     Price</span>
                             </p>
                         </div>
                     </div>
                 </div>

                 <!-- Checkboxes -->
                 <div class="space-y-4 mb-8">
                     <label class="flex items-start gap-3 cursor-pointer group">
                         <input type="checkbox"
                             class="w-5 h-5 mt-0.5 rounded border-gray-600 bg-gray-900 text-purple-600 cursor-pointer">
                         <span class="text-text-white">
                             I have read and agree to the
                             <a href="#" class="text-[#FF2E91] hover:text-red-400 transition">Terms of
                                 Service</a>.
                         </span>
                     </label>

                     <label class="flex items-start gap-3 cursor-pointer group">
                         <input type="checkbox"
                             class="w-5 h-5 mt-0.5 rounded border-gray-600 bg-gray-900 text-purple-600 cursor-pointer">
                         <span class="text-text-white">
                             I have read and agree to the
                             <a href="#" class="text-[#FF2E91] hover:text-red-400 transition">Seller Rules</a>
                             and the
                             <a href="#" class="text-[#FF2E91] hover:text-red-400 transition">Account Seller
                                 Rules</a>.
                         </span>
                     </label>
                 </div>

                 <!-- Place Offer Button -->
                 <button
                     class="bg-gradient-to-r bg-[#853EFF] text-white  px-8 py-3 rounded-full transition duration-200 shadow-lg hover:shadow-purple-500/50">
                     Place Offer
                 </button>
             </div>
         </div>




     </div> --}}

     <div class="p-4 sm:p-6">
         <div class="max-w-6xl mx-auto space-y-10">
             <!-- Main Container -->
             <div class="bg-bg-primary rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-12">
                 <!-- Title -->
                 <h1 class="text-2xl sm:text-3xl md:text-4xl font-light text-text-white mb-2 leading-snug">
                     Account information shared with buyer
                 </h1>
                 <div class="h-px bg-gradient-to-r from-purple-400 to-transparent mb-6 sm:mb-8"></div>

                 <!-- Description -->
                 <p class="text-text-gray-200 text-base sm:text-lg leading-relaxed mb-6">
                     You should provide all the details related to the account that might be relevant to have full
                     ownership of the account. This includes:
                 </p>

                 <!-- Bullet List -->
                 <ul class="space-y-2 mb-8 ml-2 sm:ml-4">
                     <li class="text-gray-300 flex items-start"><span class="mr-2 sm:mr-3">•</span><span>Character
                             name</span></li>
                     <li class="text-gray-300 flex items-start"><span class="mr-2 sm:mr-3">•</span><span>Login
                             name</span></li>
                     <li class="text-gray-300 flex items-start"><span
                             class="mr-2 sm:mr-3">•</span><span>Password</span></li>
                     <li class="text-gray-300 flex items-start"><span class="mr-2 sm:mr-3">•</span><span>Security
                             questions and answers</span></li>
                     <li class="text-gray-300 flex items-start"><span class="mr-2 sm:mr-3">•</span><span>Any extra
                             passwords/PIN/codes if applicable</span></li>
                     <li class="text-gray-300 flex items-start"><span class="mr-2 sm:mr-3">•</span><span>Any other
                             relevant info</span></li>
                 </ul>

                 <!-- Account Button -->
                 <button
                     class="w-full bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold py-3 sm:py-4 px-4 sm:px-6 rounded-2xl mb-6 transition-all duration-200 text-base sm:text-lg text-left">
                     Account 1
                 </button>

                 <!-- Character Counter -->
                 <div class="text-right text-text-white text-xs sm:text-sm mb-3 pt-4 font-medium">0/500</div>

                 <!-- Text Area -->
                 <div class="relative">
                     <textarea placeholder="Type here......" maxlength="300"
                         class="w-full bg-bg-secondary border-purple-500/30 rounded-xl p-3 sm:p-4 text-white placeholder-gray-400 focus:outline-none focus:border-purple-400/60 focus:ring-2 focus:ring-purple-500/20 transition-all resize-none h-24 sm:h-28 text-base sm:text-lg"
                         spellcheck="false"></textarea>
                 </div>
             </div>

             <!-- Quantity Section -->
             <div class="bg-bg-primary rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-12">
                 <h2
                     class="text-2xl sm:text-3xl font-light text-text-white mb-6 pb-3 sm:pb-4 border-b border-purple-500/50">
                     Quantity
                 </h2>

                 <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-8">
                     <!-- Total Quantity -->
                     <div>
                         <label class="text-text-white text-base sm:text-lg mb-2 sm:mb-3 block">Total Quantity
                             available:</label>
                         <div
                             class="bg-bg-secondary rounded-lg px-5 sm:px-6 py-3 sm:py-4 text-text-white text-center border border-purple-800/30">
                             10 Unit
                         </div>
                     </div>

                     <!-- Minimum Offer Quantity -->
                     <div>
                         <label class="text-text-white text-base sm:text-lg mb-2 sm:mb-3 block">Minimum Offer
                             quantity:</label>
                         <div
                             class="bg-bg-secondary rounded-lg px-5 sm:px-6 py-3 sm:py-4 text-text-white text-center border border-purple-800/30">
                             1 Unit
                         </div>
                     </div>
                 </div>
             </div>

             <!-- Price Section -->
             <div class="bg-bg-primary rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-12">
                 <h2
                     class="text-2xl sm:text-3xl font-light text-text-white mb-6 pb-3 sm:pb-4 border-b border-purple-500/50">
                     Price
                 </h2>

                 <div class="mb-6">
                     <label class="text-text-white text-base sm:text-lg mb-2 sm:mb-3 block">Price per account:</label>
                     <div class="flex flex-col sm:flex-row gap-3">
                         <input type="text" placeholder="Price"
                             class="flex-1 bg-bg-secondary border border-purple-800/30 rounded-lg px-5 sm:px-6 py-3 sm:py-4 text-text-white placeholder-gray-400 focus:outline-none focus:border-purple-500/50">
                         <button class="bg-[#853EFF] text-white  sm:px-6  py-3 sm:py-4 rounded-lg transition-colors">
                             USD
                         </button>
                     </div>
                 </div>

                 <p class="text-text-white text-sm sm:text-base">
                     Competitive prices improve your offer's ranking in the offer list.
                 </p>
             </div>

             <!-- Fee Structure -->
             <div class="bg-bg-primary rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-12">
                 <h2
                     class="text-2xl sm:text-3xl font-light text-text-white mb-6 pb-3 sm:pb-4 border-b border-purple-500">
                     Fee structure
                 </h2>

                 <div class="space-y-5 sm:space-y-6">
                     <p class="text-text-white text-base sm:text-lg">
                         Flat fee (per purchase): <span class="font-semibold">$0.00 USD</span>
                     </p>
                     <p class="text-text-white text-base sm:text-lg">
                         Percentage fee (per purchase): <span class="font-semibold">5% of Price</span>
                     </p>
                 </div>
             </div>

             <!-- Checkboxes -->
             <div class="space-y-4 mb-8">
                 <label class="flex items-start gap-3 cursor-pointer">
                     <input type="checkbox"
                         class="w-5 h-5 mt-0.5 rounded border-gray-600 bg-gray-900 text-purple-600 cursor-pointer">
                     <span class="text-text-white text-sm sm:text-base">
                         I have read and agree to the
                         <a href="#" class="text-[#FF2E91] hover:text-red-400 transition">Terms of Service</a>.
                     </span>
                 </label>

                 <label class="flex items-start gap-3 cursor-pointer">
                     <input type="checkbox"
                         class="w-5 h-5 mt-0.5 rounded border-gray-600 bg-gray-900 text-purple-600 cursor-pointer">
                     <span class="text-text-white text-sm sm:text-base">
                         I have read and agree to the
                         <a href="#" class="text-[#FF2E91] hover:text-red-400 transition">Seller Rules</a> and
                         the
                         <a href="#" class="text-[#FF2E91] hover:text-red-400 transition">Account Seller
                             Rules</a>.
                     </span>
                 </label>
             </div>

             <!-- Place Offer Button -->
             <div class="text-center">
                 <button
                     class="w-full sm:w-auto bg-[#853EFF] text-white px-8 py-3 sm:py-4 rounded-full transition duration-200 shadow-lg hover:shadow-purple-500/50 text-base sm:text-lg">
                     Place Offer
                 </button>
             </div>
         </div>
     </div>

 </div>
