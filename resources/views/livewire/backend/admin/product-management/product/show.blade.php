<div>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Product Details') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <x-ui.button href="{{ route('admin.pm.product.edit', $data->id) }}" variant="secondary"
                    class="w-auto py-2!">
                    <flux:icon name="pencil"
                        class="w-4 h-4 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                    {{ __('Edit') }}
                </x-ui.button>

                <x-ui.button href="{{ route('admin.pm.product.index') }}" class="w-auto py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 min-h-[500px]">
        <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">
            {{ $data->title }}
        </h3>

        {{-- Basic Information Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Basic Information') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Seller --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Seller</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->seller?->first_name ?? 'N/A' }}
                    </p>
                </div>

                {{-- Game --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Game</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->game?->name ?? 'N/A' }}
                    </p>
                </div>

                {{-- Product Type --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Product Type</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->productType?->name ?? 'N/A' }}
                    </p>
                </div>

                {{-- Slug --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Slug</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">{{ $data->slug }}</p>
                </div>

                {{-- Server --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Server</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->server?->name ?? 'N/A' }}
                    </p>
                </div>

                {{-- Platform --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Platform</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">{{ $data->platform ?? 'N/A' }}</p>
                </div>

                {{-- Region --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Region</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">{{ $data->region ?? 'N/A' }}</p>
                </div>

                {{-- Status --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Status</p>
                    <span
                        class="px-3 py-1 rounded-full text-xs font-bold inline-block badge badge-soft {{ $data->status->color() }}">
                        {{ $data->status->label() }}
                    </span>
                </div>

            </div>
        </div>

        {{-- Pricing Information Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Pricing Information') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Price --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Price</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ number_format($data->price, 2) }} {{ $data->currency }}
                    </p>
                </div>

                {{-- Currency --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Currency</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">{{ $data->currency }}
                    </p>
                </div>

                {{-- Discount Percentage --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Discount (%)</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->discount_percentage ? number_format($data->discount_percentage, 2) . '%' : '0.00%' }}
                    </p>
                </div>

                {{-- Discounted Price --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Discounted Price</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->discounted_price ? number_format($data->discounted_price, 2) . ' ' . $data->currency : 'N/A' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Stock & Inventory Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Stock & Inventory') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Stock Quantity --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Stock Quantity</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->unlimited_stock ? 'Unlimited' : $data->stock_quantity }}
                    </p>
                </div>

                {{-- Unlimited Stock --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Unlimited Stock</p>
                    <span class="rounded-full text-xs font-bold inline-block">
                        {{ $data->unlimited_stock ? __('Yes') : __('No') }}
                    </span>
                </div>

                {{-- Min Purchase Quantity --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Min Purchase Quantity</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">{{ $data->min_purchase_quantity }}
                    </p>
                </div>

                {{-- Max Purchase Quantity --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Max Purchase Quantity</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->max_purchase_quantity ?? 'N/A' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Delivery Information Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Delivery Information') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Delivery Method --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Delivery Method</p>
                    <span
                        class="px-3 py-1 rounded-full text-xs font-bold inline-block badge badge-soft {{ $data->delivery_method->color() }}">
                        {{ $data->delivery_method->label() }}
                    </span>
                </div>

                {{-- Delivery Time --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Delivery Time</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->delivery_time_hours }} {{ __('hours') }}
                    </p>
                </div>

            </div>

            {{-- Auto Delivery Content --}}
            @if ($data->auto_delivery_content)
                <div class="mt-4">
                    <p class="text-gray-500 dark:text-gray-400 mb-2">Auto Delivery Content</p>
                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                        <pre class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $data->auto_delivery_content }}</pre>
                    </div>
                </div>
            @endif
        </div>

        {{-- Sales & Performance Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Sales & Performance') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Total Sales --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Total Sales</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ number_format($data->total_sales) }}
                    </p>
                </div>

                {{-- Total Revenue --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Total Revenue</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ number_format($data->total_revenue, 2) }} {{ $data->currency }}
                    </p>
                </div>

                {{-- View Count --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">View Count</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ number_format($data->view_count) }}
                    </p>
                </div>

                {{-- Favorite Count --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Favorite Count</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ number_format($data->favorite_count) }}
                    </p>
                </div>

                {{-- Average Rating --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Average Rating</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ number_format($data->average_rating, 2) }} / 5.00
                    </p>
                </div>

                {{-- Total Reviews --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Total Reviews</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ number_format($data->total_reviews) }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Visibility & Features Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Visibility & Features') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Visibility --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Visibility</p>
                    <span class="px-3 py-1 rounded-full text-xs font-bold inline-block badge badge-soft {{ $data->visibility->color() }}">
                        {{ $data->visibility->label() }}
                    </span>
                </div>

                {{-- Is Featured --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Is Featured</p>
                    <span class="rounded-full text-xs font-bold inline-block">
                        {{ $data->is_featured ? __('Yes') : __('No') }}
                    </span>
                </div>

                {{-- Is Hot Deal --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Is Hot Deal</p>
                    <span class="rounded-full text-xs font-bold inline-block">
                        {{ $data->is_hot_deal ? __('Yes') : __('No') }}
                    </span>
                </div>

            </div>
        </div>

        {{-- Review Information Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Review Information') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Reviewed By --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Reviewed By</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->reviewer?->name ?? 'N/A' }}
                    </p>
                </div>

                {{-- Reviewed At --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Reviewed At</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->reviewed_at ? $data->reviewed_at->format('Y-m-d H:i:s') : 'N/A' }}
                    </p>
                </div>

            </div>

            {{-- Rejection Reason --}}
            @if ($data->rejection_reason)
                <div class="mt-4">
                    <p class="text-gray-500 dark:text-gray-400 mb-2">Rejection Reason</p>
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4 rounded-lg">
                        <p class="text-sm text-red-700 dark:text-red-300">{{ $data->rejection_reason }}</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- SEO Information Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('SEO Information') }}
            </h4>
            <div class="space-y-4">

                {{-- Meta Title --}}
                <div>
                    <p class="text-gray-500 dark:text-gray-400 mb-1">Meta Title</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white">
                        {{ $data->meta_title ?? 'N/A' }}
                    </p>
                </div>

                {{-- Meta Description --}}
                @if ($data->meta_description)
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">Meta Description</p>
                        <p class="text-gray-700 dark:text-gray-300">{{ $data->meta_description }}</p>
                    </div>
                @endif

                {{-- Meta Keywords --}}
                @if ($data->meta_keywords)
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1">Meta Keywords</p>
                        <p class="text-gray-700 dark:text-gray-300">{{ $data->meta_keywords }}</p>
                    </div>
                @endif

            </div>
        </div>

        {{-- Specifications Section --}}
        @if ($data->specifications)
            <div class="mb-8">
                <h4
                    class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    {{ __('Specifications') }}
                </h4>
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                    <pre class="text-sm text-gray-700 dark:text-gray-300">{{ json_encode($data->specifications, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
        @endif

        {{-- Requirements Section --}}
        @if ($data->requirements)
            <div class="mb-8">
                <h4
                    class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    {{ __('Requirements') }}
                </h4>
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                    <pre class="text-sm text-gray-700 dark:text-gray-300">{{ json_encode($data->requirements, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
        @endif

        {{-- Audit Information Section --}}
        <div class="mb-8">
            <h4
                class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                {{ __('Audit Information') }}
            </h4>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- Created Date --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Created Date</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                        {{ $data->created_at_formatted }}
                    </p>
                </div>

                {{-- Updated Date --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Updated Date</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                        {{ $data->updated_at_formatted ?? 'N/A' }}
                    </p>
                </div>

                {{-- Deleted Date --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Deleted Date</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                        {{ $data->deleted_at_formatted ?? 'N/A' }}
                    </p>
                </div>

                {{-- Restored Date --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Restored Date</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                        {{ $data->restored_at ? $data->restored_at->format('Y-m-d H:i:s') : 'N/A' }}
                    </p>
                </div>

                {{-- Created By Type --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Created By Type</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                        {{ $data->created_by_type ?? 'N/A' }}
                    </p>
                </div>

                {{-- Updated By Type --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Updated By Type</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                        {{ $data->updated_by_type ?? 'N/A' }}
                    </p>
                </div>

                {{-- Deleted By Type --}}
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">Deleted By Type</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                        {{ $data->deleted_by_type ?? 'N/A' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Description Section --}}
        @if ($data->description)
            <div class="mb-8">
                <h4
                    class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    {{ __('Description') }}
                </h4>
                <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                    {!! $data->description !!}
                </div>
            </div>
        @endif
    </div>
</div>
