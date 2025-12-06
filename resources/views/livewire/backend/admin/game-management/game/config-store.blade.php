<div x-data="{
    showConfigModal: @entangle('showConfigModal').live,
    isLoading: @entangle('isLoading').live
}" x-show="showConfigModal" x-cloak x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
    @open-config-modal.window="showConfigModal = true; isLoading = true; $wire.openConfigModal($event.detail.slug)">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showConfigModal = false; $wire.closeConfigModal()"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"></div>

    <!-- Modal Content -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-4xl bg-main rounded-2xl shadow-shadow-primary border-border max-h-[90vh] flex flex-col"
            x-show="showConfigModal" x-transition:enter="transition ease-out duration-200 delay-75"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95" @click.stop>

            <!-- Loading Overlay -->
            <div x-show="isLoading" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-main/80 backdrop-blur-sm rounded-2xl z-10 flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-12 h-12 mx-auto stroke-accent animate-spin mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    </svg>
                    <p class="text-sm font-medium text-text-muted">
                        {{ __('Loading configuration...') }}
                    </p>
                </div>
            </div>

            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-border shrink-0">
                <div class="flex-1">
                    <h3 class="text-2xl font-bold text-text-primary">
                        {{ __('Configure Category') }}
                    </h3>
                    <div x-show="!isLoading">
                        @if ($currentCategory)
                            <p class="mt-1 text-sm text-text-muted">
                                {{ __('Game') }}: <span
                                    class="font-semibold text-transparent bg-clip-text bg-linear-to-r from-accent to-primary">{{ $game->name }}</span>
                                <span class="mx-2">•</span>
                                {{ __('Category') }}: <span
                                    class="font-semibold text-transparent bg-clip-text bg-linear-to-r from-accent to-primary">{{ $currentCategory->name }}</span>
                            </p>
                        @endif
                    </div>
                    <div x-show="isLoading" class="mt-1">
                        <div class="h-4 w-64 bg-gray-200 dark:bg-gray-700 rounded animate-pulse"></div>
                    </div>
                </div>
                <button @click="showConfigModal = false; $wire.closeConfigModal()"
                    class="text-text-muted dark:hover:text-gray-200 border border-transparent hover:border-border rounded-full flex items-center justify-center w-10 h-10 hover:bg-gray-100/50 dark:hover:bg-gray-950/50 transition-all duration-300 ease-linear shrink-0 group">
                    <flux:icon name="x-mark" class="w-6 h-6 group-hover:rotate-180 transition-all duration-300" />
                </button>
            </div>

            <!-- Modal Body - Scrollable -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6" x-show="!isLoading">

                <!-- 1. DELIVERY METHODS -->
                <div
                    class="bg-linear-to-br from-zinc-50 to-secondary-50 dark:from-zinc-900/20 dark:to-secondary-900/20 p-4 rounded-xl border border-accent">
                    <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3 uppercase tracking-wide">
                        <flux:icon name="truck" class="w-4 h-4 inline mr-2" />
                        {{ __('Allowed Delivery Methods') }}
                    </label>
                    <div class="flex flex-wrap gap-4">
                        @foreach ($deliveryMethods as $key => $label)
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" wire:model.live="selectedDeliveryMethods"
                                    value="{{ $key }}"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <span
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $label }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('selectedDeliveryMethods')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 2. CUSTOM FIELDS -->
                <div class="bg-card dark:bg-card/50 p-4 rounded-xl border-border">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h4 class="text-sm font-bold text-text-primary uppercase tracking-wide">
                                <flux:icon name="squares-2x2" class="w-4 h-4 inline mr-2" />
                                {{ __('Seller Input Fields') }}
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ __('Define custom fields that sellers must fill when creating listings') }}
                            </p>
                        </div>
                        <x-ui.button wire:click="addField" size="sm" class="w-auto! px-4 py-2!">
                            <flux:icon name="plus"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            <span
                                class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Add Field') }}</span>
                        </x-ui.button>
                    </div>

                    @if (empty($fields))
                        <div class="text-center py-8 border-2 border-dashed border-border rounded-lg">
                            <flux:icon name="document-plus" class="w-12 h-12 mx-auto stroke-text-muted mb-2" />
                            <p class="text-sm text-muted">
                                {{ __('No fields defined yet. Click "Add Field" to create your first field.') }}
                            </p>
                        </div>
                    @else
                        <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                            @foreach ($fields as $index => $field)
                                <div wire:key="field-{{ $index }}"
                                    class="bg-linear-to-br from-zinc-50 via-main to-zinc-100 dark:from-zinc-900 dark:to-zinc-900 p-4 rounded-lg border-border space-y-3">

                                    <!-- Field Header with Actions -->
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="flex items-center justify-center w-6 h-6 rounded-full bg-accent text-text-primary text-xs font-bold">
                                                {{ $index + 1 }}
                                            </span>
                                            <span class="text-xs font-semibold text-text-muted">
                                                {{ __('Field') }} #{{ $index + 1 }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            @if ($index > 0)
                                                <button wire:click="moveFieldUp({{ $index }})"
                                                    class="p-1.5 text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 hover:bg-white dark:hover:bg-gray-700 rounded transition-colors"
                                                    title="{{ __('Move Up') }}">
                                                    <flux:icon name="arrow-up" class="w-4 h-4" />
                                                </button>
                                            @endif
                                            @if ($index < count($fields) - 1)
                                                <button wire:click="moveFieldDown({{ $index }})"
                                                    class="p-1.5 text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 hover:bg-white dark:hover:bg-gray-700 rounded transition-colors"
                                                    title="{{ __('Move Down') }}">
                                                    <flux:icon name="arrow-down" class="w-4 h-4" />
                                                </button>
                                            @endif
                                            <button wire:click="removeField({{ $index }})"
                                                class="p-1.5 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition-colors"
                                                title="{{ __('Delete') }}">
                                                <flux:icon name="trash" class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Field Name & Slug -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                                {{ __('Field Label') }}
                                            </label>
                                            <input type="text"
                                                wire:model.blur="fields.{{ $index }}.field_name"
                                                wire:change="updateFieldName({{ $index }}, $event.target.value)"
                                                placeholder="e.g., Server Region"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            @error('fields.' . $index . '.field_name')
                                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                                {{ __('Slug (ID)') }}
                                            </label>
                                            <input type="text" wire:model.blur="fields.{{ $index }}.slug"
                                                wire:change="updateFieldSlug({{ $index }}, $event.target.value)"
                                                placeholder="e.g., server-region"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            @error('fields.' . $index . '.slug')
                                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Input Type & Filter Type -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                                {{ __('Input Type') }}
                                            </label>
                                            <select wire:model.live="fields.{{ $index }}.input_type"
                                                wire:change="updateFieldInputType({{ $index }}, $event.target.value)"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                @foreach ($inputTypes as $type)
                                                    <option value="{{ $type['value'] }}">{{ $type['label'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                                {{ __('Filter Type') }}
                                            </label>
                                            <select wire:model.live="fields.{{ $index }}.filter_type"
                                                wire:change="updateFieldFilterType({{ $index }}, $event.target.value)"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                @foreach ($filterTypes as $type)
                                                    <option value="{{ $type['value'] }}">{{ $type['label'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Dropdown Values (Only for SELECT type) -->
                                    @if ($field['input_type'] === \App\Enums\GameConfigInputType::SELECT_DROPDOWN->value)
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                                {{ __('Dropdown Options') }}
                                                <span
                                                    class="text-gray-500 font-normal">({{ __('comma separated') }})</span>
                                            </label>
                                            <input type="text"
                                                wire:model.blur="fields.{{ $index }}.dropdown_values"
                                                wire:change="updateDropdownValues({{ $index }}, $event.target.value)"
                                                value="{{ is_array($field['dropdown_values']) ? implode(', ', $field['dropdown_values']) : '' }}"
                                                placeholder="e.g., North America, Europe, Asia"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            @if (!empty($field['dropdown_values']))
                                                <div class="mt-2 flex flex-wrap gap-1">
                                                    @foreach ($field['dropdown_values'] as $value)
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                            {{ $value }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

            <!-- Modal Footer -->
            <div
                class="flex items-center justify-between gap-3 p-6 border-t border-gray-200 dark:border-gray-700 flex-shrink-0">
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    @if (!empty($fields))
                        {{ count($fields) }} {{ __('field(s) configured') }}
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    <button @click="showConfigModal = false; $wire.closeConfigModal()" :disabled="isLoading"
                        class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ __('Cancel') }}
                    </button>
                    <x-ui.button wire:click="saveConfiguration" wire:loading.attr="disabled"
                        wire:target="saveConfiguration" class="w-auto! px-6 py-2.5!">
                        <flux:icon wire:loading.remove wire:target="saveConfiguration" name="check"
                            class="w-4 h-4 stroke-text-btn-primary" />
                        <flux:icon wire:loading wire:target="saveConfiguration" name="arrow-path"
                            class="w-4 h-4 stroke-text-btn-primary animate-spin" />
                        <span class="text-text-btn-primary">{{ __('Save Configuration') }}</span>
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>
