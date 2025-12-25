<main class="overflow-x-hidden bg-page">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <livewire:frontend.partials.page-inner-header :gameSlug="$gameSlug" :categorySlug="$categorySlug" :game="$game" />
        <!-- Breadcrumb -->
        <livewire:frontend.partials.breadcrumb :gameSlug="$gameSlug" :categorySlug="$categorySlug" />

        <div>
            <div class=" text-white min-h-screen">
                <div class="w-full mx-auto">
                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <!-- Left Column - Product Details -->
                        <x-currency.game-information :game="$game" :user="$user" :product="$product" />

                        <!-- Right Column - Product Cards -->
                        <livewire:backend.user.payments.initialize-order :productId="encrypt($product->id)" />
                    </div>
                </div>
            </div>
        </div>
     <!-- Other Sellers -->
     <div class="mt-10">
         <h2 class="text-2xl font-bold mb-6">{{ __('Other sellers (84)') }}</h2>
         <div class=" rounded-full py-4 ">
             <button
                 class="flex items-center justify-between  px-6! py-2! border border-zinc-500 rounded-full hover:bg-purple-900/20 transition">
                 <span>{{ __('Recommended') }}</span>
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6 ml-2">
                     <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                 </svg>
             </button>
         </div>
     </div>
        <!-- Product Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10 ">
            <!-- Card 1 -->
            @forelse ( $relatedProducts as $relatedProduct)
                  <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" :data="$relatedProduct" :game="$game" />
            @empty

            @endforelse

        </div>
          <x-frontend.pagination-ui :pagination="$pagination" />

</main>
