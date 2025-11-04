<div>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Product Details') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
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
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">{{ $data->currency }}</p>
            </div>

            {{-- Discount Percentage --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">Discount (%)</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->discount_percentage ? number_format($data->discount_percentage, 2) . '%' : 'N/A' }}
                </p>
            </div>

            {{-- Discounted Price --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">Discounted Price</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->discounted_price ? number_format($data->discounted_price, 2) . ' ' . $data->currency : 'N/A' }}
                </p>
            </div>

            {{-- Stock Quantity --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">Stock Quantity</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->unlimited_stock ? 'Unlimited' : $data->stock_quantity }}
                </p>
            </div>

            {{-- Min Purchase Quantity --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">Min Purchase Quantity</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">{{ $data->min_purchase_quantity }}</p>
            </div>

            {{-- Max Purchase Quantity --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">Max Purchase Quantity</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">{{ $data->max_purchase_quantity }}</p>
            </div>

            {{-- Unlimited Stock --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">Unlimited Stock</p>
                <span class="rounded-full text-xs font-bold inline-block">
                    {{ $data->unlimited_stock ? __('Yes') : __('No') }}
                </span>
            </div>

            {{-- Delivery Method --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">Delivery Method</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->delivery_method }}
                </p>
            </div>

            {{-- Delivery Time --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">Delivery Time</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->delivery_time_hours }} {{ __('hours') }}
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
                <span class="px-3 py-1 rounded-full text-xs font-bold inline-block badge badge-soft {{ $data->status->color() }}">
                    {{ $data->status->label() }}
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

            {{-- Visibility --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">Visibility</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->visibility->label() }}
                </p>
            </div>

            {{-- Meta Title --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">Meta Title</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">{{ $data->meta_title ?? 'N/A' }}</p>
            </div>

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

            {{-- Created By --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">Created By</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->creater_admin?->name ?? 'N/A' }}
                </p>
            </div>

            {{-- Updated By --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">Updated By</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->updater_admin?->name ?? 'N/A' }}
                </p>
            </div>

            {{-- Deleted By --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">Deleted By</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->deleter_admin?->name ?? 'N/A' }}
                </p>
            </div>

        </div>

        {{-- Description Section --}}
        @if($data->description)
        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">{{ __('Description') }}</h4>
            <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                {!! $data->description !!}
            </div>
        </div>
        @endif
    </div>
</div>