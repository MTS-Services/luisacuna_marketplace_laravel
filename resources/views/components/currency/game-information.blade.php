 <div class="lg:col-span-2">
     <!-- Seller Info -->
     <div class="bg-bg-primary  rounded-lg p-6 mb-6">
         <div class="flex items-center gap-4 mb-6">
            @if($user->avatar)
             <img src="{{ storage_url($user->avatar) }}" alt="{{ $user->username ?? 'User Avatar' }}"
                 class="w-16 h-16 rounded-full border-2 border-purple-500">
             @else
               <div class="bg-bg-white text-text-secondary font-bold rounded-full w-10 h-10 flex items-center justify-center">
                  
                    <span>  {{ substr($user->username, 0, 1)}}</span>
                 </div>
             @endif
             <div>
                 <h2 class="text-xl font-bold">{{ $user->first_name ?? $user->username }}</h2>
                 <div class="flex items-center gap-2 text-sm text-gray-300">
                     <span class="text-purple-400 flex items-center ">
                         <img class="px-2" src="{{ asset('assets/images/Subtract.png') }}" alt="">
                         99.3%</span>
                     <span>{{ __('2434 reviews') }}</span>
                 </div>
             </div>
         </div>

         <div class="border-t border-b border-purple-500/60 pt-4 mb-4">
             <div class="flex justify-between items-center py-3">
                 <span class="text-text-primary sm:text-2xl md:text-3xl lg:text-4xl">{{ __('Delivery time') }}
                 </span>
                 <span class="text-gray-100 sm:text-sm md:text-md lg:text-lg">
                     @foreach($product->product_configs as $product_config)
                     
                            {{ $product_config->game_configs->slug == 'delivery-speed' ? $product_config->value : '' }}

                        @endforeach
                </span>
             </div>
         </div>

      

         <!-- Product Title -->
         <h1 class="sm:text-1xl md:text-2xl lg:text-3xl mb-6">{{ $product->name }}</h1>

         <!-- How to Purchase -->
         <div class="mb-6">
            {!! $product->description !!}
         </div>

        
     </div>

     <!-- Other Sellers -->
     <div class="mt-6 ">
         <h2 class="text-2xl font-bold mb-6">{{ __('Other sellers (84)') }}</h2>
         <div class=" rounded-full p-4 ">
             <button
                 class="flex items-center justify-between  px-6 py-3 border border-purple-500/50 rounded-full hover:bg-purple-900/20 transition">
                 <span>{{ __('Recommended') }}</span>
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6 ml-2">
                     <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                 </svg>
             </button>
         </div>
     </div>
 </div>
