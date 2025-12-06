<div x-data="{
    showConfigModal: @entangle('showConfigModal').live,
    isLoading: @entangle('isLoading').live,
    fields: @entangle('fields').live,
    processingAction: false,

    addField() {
        this.fields.push({
            id: null,
            field_name: '',
            slug: '',
            input_type: 'text',
            filter_type: 'no_filter',
            dropdown_values: '',
            sort_order: this.fields.length
        });
    },

    removeField(index) {
        this.processingAction = true;
        setTimeout(() => {
            this.fields.splice(index, 1);
            this.fields.forEach((field, idx) => {
                field.sort_order = idx;
            });
            this.processingAction = false;
        }, 100);
    },

    moveFieldUp(index) {
        if (index > 0) {
            this.processingAction = true;
            setTimeout(() => {
                const temp = this.fields[index];
                this.fields[index] = this.fields[index - 1];
                this.fields[index - 1] = temp;
                this.fields[index].sort_order = index;
                this.fields[index - 1].sort_order = index - 1;
                this.processingAction = false;
            }, 100);
        }
    },

    moveFieldDown(index) {
        if (index < this.fields.length - 1) {
            this.processingAction = true;
            setTimeout(() => {
                const temp = this.fields[index];
                this.fields[index] = this.fields[index + 1];
                this.fields[index + 1] = temp;
                this.fields[index].sort_order = index;
                this.fields[index + 1].sort_order = index + 1;
                this.processingAction = false;
            }, 100);
        }
    },

    generateSlug(index) {
        const fieldName = this.fields[index].field_name;
        this.fields[index].slug = fieldName
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
}" x-show="showConfigModal" x-cloak x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
    @open-config-modal.window="showConfigModal = true; isLoading = true; $wire.openConfigModal($event.detail.slug)">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showConfigModal = false; $wire.closeConfigModal()"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100">
    </div>

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

            <!-- Action Processing Indicator -->
            <div x-show="processingAction" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                class="absolute top-4 right-4 z-20">
                <div class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span class="text-sm font-medium">{{ __('Processing...') }}</span>
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
                    <svg class="w-6 h-6  group-hover:rotate-180 transition-all duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body - Scrollable -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6" x-show="!isLoading">

                <!-- DELIVERY METHODS -->
                <div
                    class="bg-linear-to-br from-zinc-50 to-secondary-50 dark:from-zinc-900/20 dark:to-secondary-900/20 p-4 rounded-xl border border-accent">
                    <label class="block text-sm font-bold text-text-primary mb-3 uppercase tracking-wide">
                        <flux:icon name="truck" class="w-4 h-4 inline mr-2" />
                        {{ __('Allowed Delivery Methods') }}
                    </label>
                    <div class="flex flex-wrap gap-4">
                        @foreach ($deliveryMethods as $key => $label)
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" wire:model.live="selectedDeliveryMethods"
                                    value="{{ $key }}" class="w-4 h-4 checkbox checkbox-accent rounded-md">
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

                <!-- CUSTOM FIELDS -->
                <div class="bg-white dark:bg-gray-900 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wide">
                                <flux:icon name="squares-2x2" class="w-4 h-4 inline mr-2" />
                                {{ __('Seller Input Fields') }}
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ __('Define custom fields that sellers must fill when creating listings') }}
                            </p>
                        </div>
                        <x-ui.button @click="addField()" type="button"
                            class="w-auto! px-4! py-2! whitespace-nowrap rounded-lg">
                            <flux:icon name="plus"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            <span
                                class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Add Field') }}</span>
                        </x-ui.button>
                    </div>

                    <div x-show="fields.length === 0" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="text-center py-8 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg">
                        <flux:icon name="document-plus" class="w-12 h-12 mx-auto stroke-accent mb-2" />
                        <p class="text-sm text-text-muted">
                            {{ __('No fields defined yet. Click "Add Field" to create your first field.') }}
                        </p>
                    </div>

                    <div x-show="fields.length > 0" class="space-y-3 max-h-96 overflow-y-auto pr-2">
                        <template x-for="(field, index) in fields" :key="index">
                            <div x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700 space-y-3">

                                <!-- Field Header -->
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-600 text-white text-xs font-bold"
                                            x-text="index + 1"></span>
                                        <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">
                                            {{ __('Field') }} #<span x-text="index + 1"></span>
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <button x-show="index > 0" @click="moveFieldUp(index)" type="button"
                                            class="p-1.5 text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 hover:bg-white dark:hover:bg-gray-700 rounded transition-all duration-150"
                                            title="{{ __('Move Up') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7" />
                                            </svg>
                                        </button>
                                        <button x-show="index < fields.length - 1" @click="moveFieldDown(index)"
                                            type="button"
                                            class="p-1.5 text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 hover:bg-white dark:hover:bg-gray-700 rounded transition-all duration-150"
                                            title="{{ __('Move Down') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <button @click="removeField(index)" type="button"
                                            class="p-1.5 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition-all duration-150"
                                            title="{{ __('Delete') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
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
                                        <input type="text" x-model="fields[index].field_name"
                                            @input="generateSlug(index)" placeholder="e.g., Server Region"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-150">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            {{ __('Slug (ID)') }}
                                        </label>
                                        <input type="text" x-model="fields[index].slug"
                                            placeholder="e.g., server-region"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-150">
                                    </div>
                                </div>

                                <!-- Input Type & Filter Type -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            {{ __('Input Type') }}
                                        </label>
                                        <select x-model="fields[index].input_type"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-150">
                                            @foreach ($inputTypes as $type)
                                                <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            {{ __('Filter Type') }}
                                        </label>
                                        <select x-model="fields[index].filter_type"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-150">
                                            @foreach ($filterTypes as $type)
                                                <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Dropdown Values -->
                                <div x-show="fields[index].input_type === 'select_dropdown'"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100">
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('Dropdown Options') }}
                                        <span class="text-gray-500 font-normal">({{ __('comma separated') }})</span>
                                    </label>
                                    <input type="text" x-model="fields[index].dropdown_values"
                                        placeholder="e.g., North America, Europe, Asia"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-150">
                                    <div x-show="fields[index].dropdown_values" class="mt-2 flex flex-wrap gap-1">
                                        <template
                                            x-for="value in fields[index].dropdown_values.split(',').map(v => v.trim()).filter(v => v)"
                                            :key="value">
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300"
                                                x-text="value"></span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div
                class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 p-6 border-t border-border shrink-0">
                <div class="text-xs text-gray-500 dark:text-gray-400 text-center sm:text-left">
                    <span x-show="fields.length > 0">
                        <span x-text="fields.length"></span> {{ __('field(s) configured') }}
                    </span>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <button @click="showConfigModal = false; $wire.closeConfigModal()" :disabled="isLoading"
                        type="button"
                        class="bg-zinc-50 px-4 py-2 text-text-btn-secondary hover:text-text-btn-primary hover:bg-zinc-500 border border-zinc-500 focus:outline-none focus:ring focus:ring-pink-500 font-medium text-base w-full rounded-md inline-flex items-center justify-center gap-2 disabled:opacity-50 transition duration-150 ease-in-out group disabled:cursor-not-allowed">
                        {{ __('Cancel') }}
                    </button>
                    <x-ui.button wire:click="saveConfiguration" wire:loading.attr="disabled"
                        wire:target="saveConfiguration" type="button"
                        class="w-fit! rounded-md py-2! text-nowrap disabled:cursor-not-allowed">
                        <flux:icon wire:loading.remove wire:target="saveConfiguration"
                            class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-secondary" name="check" />
                        <flux:icon wire:loading wire:target="saveConfiguration"
                            class="w-4 h-4 animate-spin stroke-text-btn-primary group-hover:stroke-text-btn-secondary"
                            name="arrow-path" />
                        <span
                            class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Save Configuration') }}</span>
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>
