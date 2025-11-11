<div>
    {{-- Page Header --}}

    <div class="bg-bg-secondary w-full rounded">
        <div class="mx-auto">
            <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                        {{ __('Audit Log Details') }}
                    </h2>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <x-ui.button href="{{ route('admin.alm.audit.index') }}" class="w-auto py-2!">
                            <flux:icon name="arrow-left"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            {{ __('Back') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
            <!-- Main Card -->
            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20">

                <!-- Product Data Section -->
                <div class="px-8 py-8">
                    <div class="mb-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('SELLER ') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->seller->username }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('GAME') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->game->name }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('PRODUCT TYPE') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->productType->name }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('TITLE') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->title }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('SLUG') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->slug }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('PRICE') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->price }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('CURRENCY') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->currency->name }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('DISCOUNT PERCENTAGE') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->discount_percentage }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('DISCOUNTED PRICE') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->discounted_price ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('STOCK QUANTITY') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->stock_quantity }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('MIN PURCHASE QUANTITY') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->min_purchase_quantity }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('MAX PURCHASE QUANTITY') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->max_purchase_quantity ?? 'N/A' }}
                                </p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('UNLIMITED STOCK') }}</p>
                                <p class="text-slate-400 text-lg font-bold">
                                    {{ $data->unlimited_stock ? 'True' : 'False' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('DELIVERY METHOD') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->delivery_method }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('DELIVERY TIME HOURS') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->delivery_time_hours }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('SERVER ID') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->server_id ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('PLATFORM') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->platform ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('REGION') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->region ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('STATUS') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->status }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('IS FEATURED') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->is_featured ? 'True' : 'False' }}
                                </p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('IS HOT DEAL') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->is_hot_deal ? 'True' : 'False' }}
                                </p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('VISIBILITY') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->visibility }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('TOTAL SALES') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->total_sales }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('TOTAL REVENUE') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->total_revenue }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('VIEW COUNT') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->view_count }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('FAVORITE COUNT') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->favorite_count }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('AVERAGE RATING') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->average_rating }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('TOTAL REVIEWS') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->total_reviews }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('REVIEWED BY') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->reviewed_by ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('REVIEWED AT') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->reviewed_at ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('META TITLE') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->meta_title ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('META KEYWORDS') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->meta_keywords ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED AT') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->created_at ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED AT') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->updated_at ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('DELETED AT') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->deleted_at ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('RESTORED AT') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->restored_at ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED BY') }}</p>
                                <p class="text-slate-400 text-lg font-bold">
                                    {{ getAuditorName($data->creater) }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED BY') }}</p>
                                <p class="text-slate-400 text-lg font-bold">
                                    {{ getAuditorName($data->updater) }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('DELETED BY') }}</p>
                                <p class="text-slate-400 text-lg font-bold">
                                    {{ getAuditorName($data->deleter) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200 mt-4">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('DESCRIPTION') }}</p>
                        <p class="text-slate-400 text-lg font-bold">{!! $data->description !!}</p>
                    </div>

                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200 mt-4">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('AUTO DELIVERY CONTENT') }}</p>
                        <p class="text-slate-400 text-lg font-bold">{!! $data->auto_delivery_content ?? 'N/A' !!}</p>
                    </div>

                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200 mt-4">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('SPECIFICATIONS') }}</p>
                        <p class="text-slate-400 text-lg font-bold">
                            {{ $data->specifications ? json_encode($data->specifications) : 'N/A' }}</p>
                    </div>

                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200 mt-4">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('REQUIREMENTS') }}</p>
                        <p class="text-slate-400 text-lg font-bold">
                            {{ $data->requirements ? json_encode($data->requirements) : 'N/A' }}</p>
                    </div>

                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200 mt-4">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('REJECTION REASON') }}</p>
                        <p class="text-slate-400 text-lg font-bold">{{ $data->rejection_reason ?? 'N/A' }}</p>
                    </div>

                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200 mt-4">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('META DESCRIPTION') }}</p>
                        <p class="text-slate-400 text-lg font-bold">{{ $data->meta_description ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
