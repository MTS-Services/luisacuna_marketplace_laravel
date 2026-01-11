<div>
    {{-- Page Header --}}
    <div class="w-full">
        <div class="mx-auto">
            <div class="glass-card p-4 lg:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-primary/10 rounded-xl">
                            <flux:icon name="shopping-bag" class="w-6 h-6 text-primary" />
                        </div>
                        <div>
                            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                                {{ __('Product Details') }}
                            </h2>
                            <p class="text-sm text-text-muted">{{ $data->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <x-ui.button
                            x-on:click="$dispatch('show-translation-modal', {
                                modelId: '{{ encrypt($data->id) }}',
                                modelType: '{{ base64_encode(\App\Models\Product::class) }}'
                            })"
                            variant="secondary" class="w-auto py-2! text-nowrap">
                            <flux:icon name="arrows-pointing-out"
                                class="w-4 h-4 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                            {{ __('Manage Translations') }}
                        </x-ui.button>
                        <x-ui.button href="{{ url()->previous() !== url()->current() ? url()->previous() : route('admin.pm.category.index', $data->category->slug) }}" class="w-auto py-2! text-nowrap">
                            <flux:icon name="arrow-left"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            {{ __('Back') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Left Column: Product Info & Configs --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- 1. General Information Card --}}
                    <div class="bg-card rounded-2xl shadow-sm border border-border overflow-hidden">
                        <div class="p-6 border-b border-border bg-hover/30">
                            <h3 class="font-bold text-text-primary">{{ __('General Information') }}</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Icon & Name --}}
                                <div class="flex items-center gap-4 p-4 rounded-xl bg-main/50 border border-border">
                                    @if ($data->game && $data->game->logo)
                                        <img src="{{ storage_url($data->game->logo) }}"
                                            class="w-16 h-16 rounded-lg object-cover shadow-sm">
                                    @else
                                        <div
                                            class="w-16 h-16 rounded-lg bg-primary/20 flex items-center justify-center text-primary font-bold text-xl">
                                            {{ strtoupper(substr($data->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <label
                                            class="text-[10px] uppercase tracking-wider text-text-muted font-bold">{{ __('Product Name') }}</label>
                                        <p class="text-lg font-bold text-text-primary">{{ $data->name }}</p>
                                    </div>
                                </div>

                                {{-- Price & Stock --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-4 rounded-xl bg-main/50 border border-border">
                                        <label
                                            class="text-[10px] uppercase tracking-wider text-text-muted font-bold">{{ __('Price') }}</label>
                                        <p class="text-xl font-black text-secondary-500">
                                            {{ currency_symbol() }}{{ number_format($data->price, 2) }}
                                        </p>
                                    </div>
                                    <div class="p-4 rounded-xl bg-main/50 border border-border">
                                        <label
                                            class="text-[10px] uppercase tracking-wider text-text-muted font-bold">{{ __('Stock') }}</label>
                                        <p class="text-xl font-black text-text-primary">{{ $data->quantity }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-2 md:grid-cols-3 gap-4">
                                <div class="space-y-1">
                                    <span class="text-xs text-text-muted">{{ __('Game') }}</span>
                                    <p class="font-semibold text-text-primary">{{ $data->game->name ?? 'N/A' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-xs text-text-muted">{{ __('Category') }}</span>
                                    <p class="font-semibold text-text-primary">{{ $data->category->name ?? 'N/A' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-xs text-text-muted">{{ __('Platform') }}</span>
                                    <p class="font-semibold text-text-primary">{{ $data->platform->name ?? 'N/A' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-xs text-text-muted">{{ __('Status') }}</span>
                                    <div>
                                        <span
                                            class="badge badge-soft {{ $data->status->color() }}">{{ $data->status->label() }}</span>
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-xs text-text-muted">{{ __('Delivery Timeline') }}</span>
                                    <p class="font-semibold text-text-primary">
                                        {{ $data->delivery_timeline ?? 'Instant' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-xs text-text-muted">{{ __('Delivery Method') }}</span>
                                    <p class="font-semibold text-text-primary">
                                        {{ $data->delivery_method ?? 'Automatic' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Product Configurations (Specifications) --}}
                    <div class="bg-card rounded-2xl shadow-sm border border-border overflow-hidden">
                        <div class="p-6 border-b border-border bg-hover/30 flex items-center justify-between">
                            <h3 class="font-bold text-text-primary flex items-center gap-2">
                                <flux:icon name="adjustments-horizontal" class="w-5 h-5 text-primary" />
                                {{ __('Product Specifications') }}
                            </h3>
                        </div>
                        <div class="p-6">
                            {{-- @dd($data->product_configs) --}}
                            @if ($data->product_configs && $data->product_configs->isNotEmpty())
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($data->product_configs as $config)
                                        {{-- Skip if no label exists to avoid empty cards --}}
                                        @if (!$config->game_configs)
                                            @continue
                                        @endif

                                        <div
                                            class="flex flex-col p-4 rounded-xl bg-main/40 border border-border/60 hover:border-primary/50 transition-all">
                                            <span
                                                class="text-[10px] uppercase tracking-widest text-text-muted font-bold mb-1">
                                                {{ $config->game_configs->field_name ?? __('Attribute') }}
                                            </span>
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-bold text-text-primary">
                                                    {{ $config->value ?? '—' }}
                                                </p>
                                                {{-- Optional: Add an icon if value is a boolean/check --}}
                                                @if (strtolower($config->value) == 'yes' || $config->value == '1')
                                                    <flux:icon name="check-badge" class="w-4 h-4 text-green-500"
                                                        variant="micro" />
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-8 opacity-60">
                                    <flux:icon name="document-magnifying-glass" class="w-12 h-12 mb-2 stroke-1" />
                                    <p class="text-sm text-text-muted">{{ __('No configuration values found.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- 3. Description Card --}}
                    <div class="bg-card rounded-2xl shadow-sm border border-border overflow-hidden">
                        <div class="p-6 border-b border-border bg-hover/30">
                            <h3 class="font-bold text-text-primary">{{ __('Detailed Description') }}</h3>
                        </div>
                        <div class="p-6">
                            <div class="prose prose-invert max-w-none text-text-secondary">
                                {!! $data->description !!}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Seller & Meta Info --}}
                <div class="space-y-6">
                    {{-- Seller Information Card --}}
                    <div class="bg-card rounded-2xl shadow-sm border border-border overflow-hidden">
                        <div class="p-6 border-b border-border bg-hover/30">
                            <h3 class="font-bold text-text-primary">{{ __('Seller Information') }}</h3>
                        </div>
                        <div class="p-6">
                            @if ($data->user)
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="relative">
                                        <img src="{{ auth_storage_url($data->user->avatar) ?? 'https://ui-avatars.com/api/?name=' . urlencode($data->user->full_name) }}"
                                            class="w-14 h-14 rounded-full border-2 border-primary/30 object-cover">
                                        <span
                                            class="absolute bottom-0 right-0 w-3.5 h-3.5 rounded-full border-2 border-card {{ $data->user->last_seen_at ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                                    </div>
                                    <div class="overflow-hidden">
                                        <a href="{{ route('profile', $data->user->username) }}" target="_blank"
                                            class="font-bold text-text-primary hover:text-primary transition-colors block truncate">
                                            {{ $data->user->first_name }} {{ $data->user->last_name }}
                                        </a>
                                        <a href="mailto:{{ $data->user->email }}"
                                            class="hover:underline block truncate">
                                            <p class="text-xs text-text-muted">{{ $data->user->email }}</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="space-y-3 text-sm">
                                    <div class="flex justify-between items-center">
                                        <span class="text-text-muted">{{ __('Username') }}:</span>
                                        <span
                                            class="font-medium text-text-secondary">{{ $data->user->username }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-text-muted">{{ __('Status') }}:</span>
                                        <span
                                            class="px-2 py-0.5 rounded bg-primary/10 text-primary text-[10px] font-bold uppercase">
                                            {{ $data->user->account_status ?? 'Active' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-text-muted">{{ __('Joined') }}:</span>
                                        <span
                                            class="text-text-secondary">{{ $data->user->created_at?->format('M Y') }}</span>
                                    </div>
                                </div>
                            @else
                                <p class="text-text-muted italic text-center py-4">{{ __('No seller assigned.') }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- System Logs Card --}}
                    <div class="bg-card rounded-2xl shadow-sm border border-border p-6 space-y-4">
                        <h3 class="font-bold text-text-primary text-sm uppercase tracking-wider">
                            {{ __('Audit Trail') }}</h3>

                        <div class="space-y-4">
                            <div class="flex gap-3">
                                <div class="p-2 bg-main rounded-lg h-fit">
                                    <flux:icon name="calendar" class="w-4 h-4 text-text-muted" />
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-text-muted tracking-tight">
                                        {{ __('Date Created') }}</p>
                                    <p class="text-sm font-medium text-text-primary">{{ $data->created_at_formatted }}
                                    </p>
                                    <p class="text-[10px] text-primary font-medium">
                                        {{ $data->creater_admin->name ?? 'System' }}</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="p-2 bg-main rounded-lg h-fit">
                                    <flux:icon name="pencil-square" class="w-4 h-4 text-text-muted" />
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-text-muted tracking-tight">
                                        {{ __('Last Modified') }}</p>
                                    <p class="text-sm font-medium text-text-primary">{{ $data->updated_at_formatted }}
                                    </p>
                                    <p class="text-[10px] text-primary font-medium">
                                        {{ $data->updater_admin->name ?? 'System' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
