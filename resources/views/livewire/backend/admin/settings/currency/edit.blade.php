<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Currency Edit') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.as.currency.index') }}" class="w-auto py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>


    {{-- Default Currency Info Card --}}
    @if (isset($defaultCurrency))
        <div class="glass-card rounded-2xl p-6 mb-6">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 mt-1">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-zinc-100 dark:bg-zinc-900/30">
                        <flux:icon name="information-circle" class="w-5 h-5 text-zinc-600 dark:text-zinc-400" />
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-zinc-800 dark:text-zinc-300 mb-2">
                        {{ __('Default Currency Information') }}
                    </h3>
                    <div
                        class="flex items-center gap-3 p-3 rounded-lg bg-zinc-50 dark:bg-zinc-900/20 border border-zinc-200 dark:border-zinc-800">
                        <span class="text-2xl">{{ $defaultCurrency->symbol }}</span>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $defaultCurrency->name }}
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                {{ $defaultCurrency->code }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Exchange Rate') }}</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ number_format($defaultCurrency->exchange_rate, $defaultCurrency->decimal_places) }}
                            </p>
                        </div>
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            {{ __('Default') }}
                        </span>
                    </div>
                    <p class="text-xs text-zinc-700 dark:text-zinc-400 mt-2">
                        {{ __('Exchange rates for new currencies should be relative to this default currency.') }}
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="glass-card rounded-2xl p-6 mb-6">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 mt-1">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                        <flux:icon name="exclamation-triangle" class="w-5 h-5 text-yellow-600 dark:text-yellow-500" />
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-yellow-800 dark:text-yellow-300 mb-1">
                        {{ __('No Default Currency Set') }}
                    </h3>
                    <p class="text-xs text-yellow-700 dark:text-yellow-400">
                        {{ __('This will be the first currency. Consider setting it as default or set exchange rate to 1.00.') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">
            <!-- Fields -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">
                <div>
                    <x-ui.label for="name" :value="__('Name')" required />
                    <x-ui.input id="name" type="text" class="mt-1 block w-full" wire:model="form.name"
                        placeholder="US Dollar, Euro, British Pound, Bangladeshi Taka" />
                    <x-ui.input-error :messages="$errors->get('form.name')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="code" :value="__('Code')" required />
                    <x-ui.input id="code" type="text" class="mt-1 block w-full" wire:model="form.code"
                        placeholder="USD, EUR, GBP, BDT" />
                    <x-ui.input-error :messages="$errors->get('form.code')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="symbol" :value="__('Symbol')" />
                    <x-ui.input id="symbol" type="text" class="mt-1 block w-full" wire:model="form.symbol"
                        placeholder="&\#xa3;, &\#xa2;, &\#x24;" />
                    <x-ui.input-error :messages="$errors->get('form.symbol')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="exchange_rate" :value="__('Exchange Rate')" />
                    <x-ui.input id="exchange_rate" type="text" class="mt-1 block w-full"
                        wire:model="form.exchange_rate" placeholder="Enter exchange rate. e.g. 100" />
                    <x-ui.input-error :messages="$errors->get('form.exchange_rate')" class="mt-2" />
                </div>
            </div>
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">
                <div>
                    <x-ui.label for="decimal_places" :value="__('Decimal Places')" />
                    <x-ui.input id="decimal_places" type="number" class="mt-1 block w-full"
                        wire:model="form.decimal_places" placeholder="Enter decimal places. e.g. 2" />
                    <x-ui.input-error :messages="$errors->get('form.decimal_places')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="status" :value="__('Status')" required />
                    <x-ui.select id="status" class="mt-1 block w-full" wire:model="form.status">
                        <option value="">{{ __('Select Status') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" class="mt-2" />
                </div>
                {{-- <div>
                    <x-ui.label for="is_default" :value="__('Is Default Currency?')" required />
                    <x-ui.select id="is_default" class="mt-1 block w-full" wire:model="form.is_default">
                        <option value="">{{ __('Select Option') }}</option>
                        <option value="1">{{ __('Yes') }}</option>
                        <option value="0">{{ __('No') }}</option>
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.is_default')" class="mt-2" />
                </div> --}}
            </div>

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
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Update ') }}</span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Updating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
