 <div class="flex gap-4 items-center my-10">
     <div class="w-4 h-4">
         <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
     </div>
     <h1 class=" text-text-primary">

         {{ ucwords(str_replace('-', ' ', $gameSlug)) . ' ' . ucwords(str_replace('-', ' ', $categorySlug)) }}

     </h1>
     <span class=" text-text-primary">></span>
     <span class=" text-text-primary">{{ __('Shop') }}</span>
 </div>
