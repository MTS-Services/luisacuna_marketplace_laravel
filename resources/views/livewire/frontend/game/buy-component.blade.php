<main class="overflow-x-hidden bg-page">
    <div class="max-w-7xl mx-auto px-4 py-8 mb-10">
        <livewire:frontend.partials.page-inner-header :gameSlug="$gameSlug" :categorySlug="$categorySlug" :game="$game" />
        <!-- Breadcrumb -->
        {{-- <livewire:frontend.partials.breadcrumb :gameSlug="$gameSlug" :categorySlug="$categorySlug" /> --}}

        <div>
            <div class=" text-white min-h-screen">
                <div class="w-full mx-auto">
                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-10">

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
            <h2 class="text-2xl font-bold mb-6">{{ __('Other sellers') }} {{ $relatedProducts->count() ?? 0 }}</h2>
            <div class=" rounded-full py-4 ">
                <x-ui.custom-select wireModel="sellerFilter" :wireLive="true" :label="__('Recommended')"
                    class="py-3! w-full sm:w-70 rounded-full!">
                    <x-ui.custom-option label="{{ __('Recommended') }}" value="recommended" />
                    <x-ui.custom-option label="{{ __('Positive Reviews') }}" value="positive_reviews" />
                    <x-ui.custom-option label="{{ __('Top Sold') }}" value="top_sold" />
                    <x-ui.custom-option label="{{ __('Lowest Price') }}" value="lowest_price" />
                    <x-ui.custom-option label="{{ __('In Stock') }}" value="in_stock" />
                </x-ui.custom-select>
            </div>
        </div>
        <!-- Product Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10 ">
            <!-- Card 1 -->
            @forelse ($relatedProducts as $relatedProduct)
                <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" :data="$relatedProduct" :game="$game" />
            @empty
                <x-ui.empty-card />
            @endforelse

        </div>
        <x-frontend.pagination-ui :pagination="$pagination" />

</main>
