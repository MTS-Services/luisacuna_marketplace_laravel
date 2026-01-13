 <div class="lg:col-span-2">
     <!-- Seller Info -->
     <div class="bg-bg-primary dark:bg-bg-secondary  rounded-lg p-6 mb-6">
         {{-- <div class="flex items-center gap-4 mb-6">
             @if ($user->avatar)
                 <img src="{{ auth_storage_url($user->avatar) }}" alt="{{ $user->username ?? 'User Avatar' }}"
                     class="w-16 h-16 rounded-full border-2 border-purple-500">
             @else
                 <div
                     class="bg-bg-white text-text-secondary font-bold rounded-full w-10 h-10 flex items-center justify-center">

                     <span> {{ substr($user->username, 0, 1) }}</span>
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
         </div> --}}

         {{-- <div class="border-t border-b border-purple-500/60 pt-4 mb-4">
             <div class="flex justify-between items-center py-3">
                 <span class="text-text-primary sm:text-2xl md:text-3xl lg:text-4xl">{{ __('Delivery time') }}
                 </span>
                 <span class="text-gray-100 sm:text-sm md:text-md lg:text-lg">
                     @foreach ($product->product_configs as $product_config)
                         {{ $product_config->game_configs->slug == 'delivery-speed' ? $product_config->value : '' }}
                     @endforeach
                 </span>
             </div>
         </div> --}}



         <!-- Product Title -->
         <h1 class="sm:text-1xl md:text-2xl lg:text-3xl pb-6 mb-6 border-b text-text-primary border-purple-500/60"> {{ $product->translatedName(app()->getLocale()) }}</h1>

         <!-- How to Purchase -->
         <div class="mb-6 text-text-primary">
             {!! $product->description !!}
              {{-- {{ $product->translatedDescription(app()->getLocale()) }} --}}
         </div>


     </div>


 </div>
