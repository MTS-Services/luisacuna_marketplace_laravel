<section>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/ckEditor.css') }}">
    @endpush
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Product Type Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.pm.productType.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">
            {{-- <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Icon') }}
                </h3>
                <x-ui.file-input wire:model="form.icon" label="Icon" accept="image/*" :error="$errors->first('form.icon')"
                    hint="Upload a Icon (Max: 2MB)" />
            </div> --}}

            <!-- Add other form fields here -->
            {{-- <div class="mt-6 space-y-4 grid grid-cols-2 gap-5"> --}}
            {{-- name --}}
            {{-- <div class="w-full">
                    <x-ui.label value="Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Name" id="name" wire:model="form.name" />
                    <x-ui.input-error :messages="$errors->get('form.name')" />
                </div> --}}

            {{-- slug --}}
            {{-- <div class="w-full">
                    <x-ui.label value="Slug" class="mb-1" />
                    <x-ui.input type="text" placeholder="Slug" id="slug" wire:model="form.slug" />
                    <x-ui.input-error :messages="$errors->get('form.slug')" />
                </div> --}}

            {{-- commission_rate --}}
            {{-- <div class="w-full">
                    <x-ui.label value="Commission Rate" class="mb-1" />
                    <x-ui.input type="number" placeholder="Commission Rate" wire:model="form.commission_rate" />
                    <x-ui.input-error :messages="$errors->get('form.commission_rate')" />
                </div> --}}

            {{-- status --}}
            {{-- <div class="w-full">
                    <x-ui.label value="Status Select" class="mb-1" />
                    <x-ui.select wire:model="form.status">
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" />
                </div> --}}

            {{-- </div> --}}
            {{-- description --}}
            {{-- <div class="w-full mt-2">
                <x-ui.label value="Description" class="mb-1" />
                <x-ui.text-editor model="content1" wire:model.live="form.description" id="text-editor-main-content"
                    placeholder="Enter your main content here..." :height="350" />

                <x-ui.input-error :messages="$errors->get('form.description')" />
            </div> --}}
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">

                {{-- seller_id --}}
                <div class="w-full">
                    <x-ui.label value="Seller ID" for="seller_id" class="mb-1" />
                    <x-ui.select wire:model="form.seller_id" id="seller_id">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.seller_id')" />
                </div>

                {{-- game --}}
                <div class="w-full">
                    <x-ui.label value="Game Select" class="mb-1" />
                    <x-ui.select wire:model="form.game_id">
                        @foreach ($games as $game)
                            <option value="{{ $game->id }}">{{ $game['name'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.game_id')" />
                </div>

                {{-- product_type_id --}}
                <div class="w-full">
                    <x-ui.label value="Product Type Select" class="mb-1" />
                    <x-ui.select wire:model="form.product_type_id">
                        @foreach ($PTypes as $PType)
                            <option value="{{ $PType->id }}">{{ $PType['name'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.product_type_id')" />
                </div>

                {{-- title --}}
                <div class="w-full">
                    <x-ui.label value="Title" class="mb-1" />
                    <x-ui.input type="text" placeholder="Title" id="title" wire:model="form.title" />
                    <x-ui.input-error :messages="$errors->get('form.title')" />
                </div>

                {{-- slug --}}
                <div class="w-full">
                    <x-ui.label value="Slug" class="mb-1" />
                    <x-ui.input type="text" placeholder="Slug" id="slug" wire:model="form.slug" />
                    <x-ui.input-error :messages="$errors->get('form.slug')" />
                </div>

                {{-- price --}}
                <div class="w-full">
                    <x-ui.label value="Price" class="mb-1" />
                    <x-ui.input type="number" step="0.01" placeholder="Price" wire:model="form.price" />
                    <x-ui.input-error :messages="$errors->get('form.price')" />
                </div>

                {{-- currency --}}
                <div class="w-full">
                    <x-ui.label value="Currency" class="mb-1" />
                    <x-ui.input type="text" maxlength="3" placeholder="Currency (e.g. USD)"
                        wire:model="form.currency" />
                    <x-ui.input-error :messages="$errors->get('form.currency')" />
                </div>

                {{-- discount_percentage --}}
                <div class="w-full">
                    <x-ui.label value="Discount (%)" class="mb-1" />
                    <x-ui.input type="number" step="0.01" placeholder="Discount %"
                        wire:model="form.discount_percentage" />
                    <x-ui.input-error :messages="$errors->get('form.discount_percentage')" />
                </div>

                {{-- discounted_price --}}
                <div class="w-full">
                    <x-ui.label value="Discounted Price" class="mb-1" />
                    <x-ui.input type="number" step="0.01" placeholder="Discounted Price"
                        wire:model="form.discounted_price" />
                    <x-ui.input-error :messages="$errors->get('form.discounted_price')" />
                </div>

                {{-- stock_quantity --}}
                <div class="w-full">
                    <x-ui.label value="Stock Quantity" class="mb-1" />
                    <x-ui.input type="number" placeholder="Stock Quantity" wire:model="form.stock_quantity" />
                    <x-ui.input-error :messages="$errors->get('form.stock_quantity')" />
                </div>

                {{-- min_purchase_quantity --}}
                <div class="w-full">
                    <x-ui.label value="Min Purchase Quantity" class="mb-1" />
                    <x-ui.input type="number" placeholder="Min Purchase Quantity"
                        wire:model="form.min_purchase_quantity" />
                    <x-ui.input-error :messages="$errors->get('form.min_purchase_quantity')" />
                </div>

                {{-- max_purchase_quantity --}}
                <div class="w-full">
                    <x-ui.label value="Max Purchase Quantity" class="mb-1" />
                    <x-ui.input type="number" placeholder="Max Purchase Quantity"
                        wire:model="form.max_purchase_quantity" />
                    <x-ui.input-error :messages="$errors->get('form.max_purchase_quantity')" />
                </div>

                {{-- unlimited_stock --}}
                <div class="w-full">
                    <x-ui.label value="Unlimited Stock" class="mb-1" />
                    <input type="checkbox" wire:model="form.unlimited_stock" />
                    <x-ui.input-error :messages="$errors->get('form.unlimited_stock')" />
                </div>

                {{-- delivery_method --}}
                <div class="w-full">
                    <x-ui.label value="Delivery Method" class="mb-1" />
                    <x-ui.select wire:model="form.delivery_method">
                        @foreach ($deliveryMethods as $deliveryMethod)
                            <option value="{{ $deliveryMethod['value'] }}">{{ $deliveryMethod['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.delivery_method')" />
                </div>

                {{-- delivery_time_hours --}}
                <div class="w-full">
                    <x-ui.label value="Delivery Time (hours)" class="mb-1" />
                    <x-ui.input type="number" placeholder="Delivery Time (hours)"
                        wire:model="form.delivery_time_hours" />
                    <x-ui.input-error :messages="$errors->get('form.delivery_time_hours')" />
                </div>

                {{-- server_id --}}
                {{-- <div class="w-full">
                    <x-ui.label value="Server ID" class="mb-1" />
                    <x-ui.input type="number" placeholder="Server ID" wire:model="form.server_id" />
                    <x-ui.input-error :messages="$errors->get('form.server_id')" />
                </div> --}}

                {{-- platform --}}
                <div class="w-full">
                    <x-ui.label value="Platform" class="mb-1" />
                    <x-ui.input type="text" placeholder="Platform" wire:model="form.platform" />
                    <x-ui.input-error :messages="$errors->get('form.platform')" />
                </div>

                {{-- region --}}
                <div class="w-full">
                    <x-ui.label value="Region" class="mb-1" />
                    <x-ui.input type="text" placeholder="Region" wire:model="form.region" />
                    <x-ui.input-error :messages="$errors->get('form.region')" />
                </div>

                {{-- status --}}
                <div class="w-full">
                    <x-ui.label value="Status" class="mb-1" />
                    <x-ui.input type="text" placeholder="Status" wire:model="form.status" />
                    <x-ui.input-error :messages="$errors->get('form.status')" />
                </div>

                {{-- is_featured --}}
                <div class="w-full">
                    <x-ui.label value="Is Featured" class="mb-1" />
                    <input type="checkbox"  wire:model="form.is_featured" />
                    <x-ui.input-error :messages="$errors->get('form.is_featured')" />
                </div>

                {{-- is_hot_deal --}}
                <div class="w-full">
                    <x-ui.label value="Is Hot Deal" class="mb-1" />
                    <input type="checkbox" wire:model="form.is_hot_deal" />
                    <x-ui.input-error :messages="$errors->get('form.is_hot_deal')" />
                </div>

                {{-- visibility --}}
                <div class="w-full">
                    <x-ui.label value="Visibility" class="mb-1" />
                    <x-ui.select wire:model="form.visibility">
                        @foreach ($visibilitis as $visibility)
                            <option value="{{ $visibility['value'] }}">{{ $visibility['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.visibility')" />
                </div>

                {{-- total_sales --}}
                {{-- <div class="w-full">
                    <x-ui.label value="Total Sales" class="mb-1" />
                    <x-ui.input type="number" placeholder="Total Sales" wire:model="form.total_sales" />
                    <x-ui.input-error :messages="$errors->get('form.total_sales')" />
                </div> --}}

                {{-- total_revenue --}}
                {{-- <div class="w-full">
                    <x-ui.label value="Total Revenue" class="mb-1" />
                    <x-ui.input type="number" step="0.01" placeholder="Total Revenue"
                        wire:model="form.total_revenue" />
                    <x-ui.input-error :messages="$errors->get('form.total_revenue')" />
                </div> --}}

                {{-- view_count --}}
                {{-- <div class="w-full">
                    <x-ui.label value="View Count" class="mb-1" />
                    <x-ui.input type="number" placeholder="View Count" wire:model="form.view_count" />
                    <x-ui.input-error :messages="$errors->get('form.view_count')" />
                </div> --}}

                {{-- favorite_count --}}
                {{-- <div class="w-full">
                    <x-ui.label value="Favorite Count" class="mb-1" />
                    <x-ui.input type="number" placeholder="Favorite Count" wire:model="form.favorite_count" />
                    <x-ui.input-error :messages="$errors->get('form.favorite_count')" />
                </div> --}}

                {{-- average_rating --}}
                {{-- <div class="w-full">
                    <x-ui.label value="Average Rating" class="mb-1" />
                    <x-ui.input type="number" step="0.01" placeholder="Average Rating"
                        wire:model="form.average_rating" />
                    <x-ui.input-error :messages="$errors->get('form.average_rating')" />
                </div> --}}

                {{-- total_reviews --}}
                {{-- <div class="w-full">
                    <x-ui.label value="Total Reviews" class="mb-1" />
                    <x-ui.input type="number" placeholder="Total Reviews" wire:model="form.total_reviews" />
                    <x-ui.input-error :messages="$errors->get('form.total_reviews')" />
                </div> --}}

                {{-- reviewed_by --}}
                {{-- <div class="w-full">
                    <x-ui.label value="Reviewed By" class="mb-1" />
                    <x-ui.input type="number" placeholder="Reviewed By" wire:model="form.reviewed_by" />
                    <x-ui.input-error :messages="$errors->get('form.reviewed_by')" />
                </div> --}}

                {{-- reviewed_at --}}
                {{-- <div class="w-full">
                    <x-ui.label value="Reviewed At" class="mb-1" />
                    <x-ui.input type="datetime-local" wire:model="form.reviewed_at" />
                    <x-ui.input-error :messages="$errors->get('form.reviewed_at')" />
                </div> --}}

                {{-- meta_title --}}
                <div class="w-full">
                    <x-ui.label value="Meta Title" class="mb-1" />
                    <x-ui.input type="text" placeholder="Meta Title" wire:model="form.meta_title" />
                    <x-ui.input-error :messages="$errors->get('form.meta_title')" />
                </div>

            </div>

            {{-- description --}}
            <div class="w-full mt-4">
                <x-ui.label value="Description" class="mb-1" />
                <x-ui.text-editor wire:model.live="form.description" id="description"
                    placeholder="Enter description..." :height="350" />
                <x-ui.input-error :messages="$errors->get('form.description')" />
            </div>

            {{-- auto_delivery_content --}}
            {{-- <div class="w-full mt-4">
                <x-ui.label value="Auto Delivery Content" class="mb-1" />
                <x-ui.text-editor wire:model.live="form.auto_delivery_content" id="auto_delivery_content"
                    placeholder="Enter delivery instructions..." :height="250" />
                <x-ui.input-error :messages="$errors->get('form.auto_delivery_content')" />
            </div> --}}

            {{-- rejection_reason --}}
            {{-- <div class="w-full mt-4">
                <x-ui.label value="Rejection Reason" class="mb-1" />
                <x-ui.text-editor wire:model.live="form.rejection_reason" id="rejection_reason"
                    placeholder="Reason for rejection (if any)" :height="200" />
                <x-ui.input-error :messages="$errors->get('form.rejection_reason')" />
            </div> --}}

            {{-- meta_description --}}
            {{-- <div class="w-full mt-4">
                <x-ui.label value="Meta Description" class="mb-1" />
                <x-ui.text-editor wire:model.live="form.meta_description" id="meta_description"
                    placeholder="Enter meta description..." :height="200" />
                <x-ui.input-error :messages="$errors->get('form.meta_description')" />
            </div> --}}

            {{-- meta_keywords --}}
            {{-- <div class="w-full mt-4">
                <x-ui.label value="Meta Keywords" class="mb-1" />
                <x-ui.text-editor wire:model.live="form.meta_keywords" id="meta_keywords"
                    placeholder="Enter meta keywords..." :height="200" />
                <x-ui.input-error :messages="$errors->get('form.meta_keywords')" />
            </div> --}}

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:click="resetForm" variant="tertiary" class="w-auto! py-2!">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    <span wire:loading.remove wire:target="resetForm"
                        class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Reset') }}</span>
                    <span wire:loading wire:target="resetForm"
                        class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Reseting...') }}</span>
                </x-ui.button>

                <x-ui.button class="w-auto! py-2!" type="submit">
                    <span wire:loading.remove wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Create Product') }}</span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Saving...') }}</span>
                </x-ui.button>
            </div>
        </form>

    </div>

    @push('scripts')
        {{-- Auto slug script --}}
        <script>
            document.getElementById('title').addEventListener('input', function() {
                let slug = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/\s+/g, '-');
                document.getElementById('slug').value = slug;

                document.getElementById('slug').dispatchEvent(new Event('input'));
            });
        </script>
    @endpush
</section>
