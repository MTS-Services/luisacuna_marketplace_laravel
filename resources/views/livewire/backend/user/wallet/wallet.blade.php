<div class="space-y-6">
    {{-- Balance card --}}
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Balance Card -->
        <div class="w-full md:w-1/2 bg-bg-secondary rounded-2xl p-6 md:p-10">
            <div class="bg-bg-optional rounded-2xl p-5 md:p-7">
                <div class="bg-bg-info rounded-2xl p-5 md:p-7">
                    <div class="flex flex-col lg:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="text-text-white">{{ __('Balance') }}</p>
                            <h2 class="text-text-white text-2xl font-semibold mt-2">
                                {{ currency_symbol() }}{{ currency_exchange($wallet->balance ?? 0) }}</h2>
                            <p class="text-text-white mt-2 text-sm md:text-base">
                                {{ __('Withdrawals require') }} {{ currency_symbol() }}{{ currency_exchange(10) }}
                                {{ __('in completed sales') }}
                            </p>
                            <a href="#" class="text-pink-500 mt-2 inline-block">{{ __('Learn more') }}</a>
                        </div>
                        <div>
                            <x-ui.button href="{{ route('user.wallet.withdrawal-methods') }}" class="w-fit! py-3! px-6!">
                                <span
                                    class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Withdraw') }}</span>
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Sales Card -->
        <div class="w-full md:w-1/2 bg-bg-secondary rounded-2xl p-6 md:p-10">
            <div class="bg-bg-optional rounded-2xl p-5 md:p-7">
                <div class="bg-bg-info rounded-2xl p-5 md:p-7">
                    <h2 class="text-text-white text-2xl font-semibold">{{ __('Pending Sales') }}</h2>
                    <p class="text-text-white mt-2 text-sm md:text-base">
                        {{ __('Revenue from pending orders. Funds will be added to your balance when orders are Completed.') }}
                    </p>
                    <h2 class="text-text-white text-2xl font-semibold mt-2">
                        {{ currency_symbol() }}{{ currency_exchange($wallet->pending_balance ?? 0) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="p-4 w-full">
        <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-3 lg:gap-4">

            <!-- Left Side: Filters -->
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">

                <div class="py-0.5! w-full sm:w-70">
                    <x-ui.custom-select :wireModel="'status'" class="rounded!" label="{{ __('All Statuses') }}">
                        <x-ui.custom-option label="purchased" value="{{ __('purchased') }}" />
                        <x-ui.custom-option label="sales" value="{{ __('Sales') }}" />
                        <x-ui.custom-option label="withdrawls" value="{{ __('Withdrawls') }}" />
                    </x-ui.custom-select>
                </div>

                <div class="py-0.5! w-full sm:w-70">
                    <x-ui.custom-select :wireModel="'time'" class="rounded!" label="{{ __('Recent') }}">
                        <x-ui.custom-option value="today" label="{{ __('Today') }}" />
                        <x-ui.custom-option value="week" label="{{ __('This Week') }}" />
                        <x-ui.custom-option value="month" label="{{ __('This Month') }}" />
                    </x-ui.custom-select>
                </div>

                {{-- <div class="relative w-full sm:w-56">
                    <x-ui.input type="text" placeholder="{{ __('Search') }}" class="pl-5 border-zinc-500! placeholder:text-text-primary" />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <x-phosphor-magnifying-glass class="w-5 h-5 fill-text-text-white" />
                    </div>
                </div> --}}

            </div>

            <!-- Right Side: Search & Actions -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full lg:w-auto">
                <!-- Manage Subscriptions Button -->
                <a href="{{ route('user.subscriptions') }}">
                    <x-ui.button class="w-full sm:w-auto! py-2!">
                        <span
                            class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Manage Subscriptions') }}</span>
                    </x-ui.button>
                </a>
            </div>
        </div>
    </div>

    <div>
        <x-ui.user-table :data="$datas" :columns="$columns"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />
        {{-- <x-frontend.pagination-ui :pagination="$pagination" /> --}}
    </div>

</div>
