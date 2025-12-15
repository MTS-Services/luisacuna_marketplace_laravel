<div x-data="{
    open: false,
    additionalNotes: @entangle('form.additional').live,
    editingKey: null,
    tempKeys: {},
    keyCounter: 1,
    getNextKeyName() {
        const keyName = 'key_' + String(this.keyCounter).padStart(2, '0');
        this.keyCounter++;
        return keyName;
    }
}" @announcement-send-modal-show.window="open = true"
    @announcement-modal-close.window="open = false"
    @keydown.escape.window="if(open) { open = false; $wire.call('resetForm'); }">

    <!-- Overlay -->
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        @click="open = false; $wire.call('resetForm')" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm"></div>

    <!-- Modal -->
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 z-50 flex items-center justify-center p-4">

        <div @click.stop
            class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-6xl w-full relative overflow-hidden max-h-[90vh] flex flex-col">

            <!-- Header with gradient -->
            <div class="bg-linear-to-r from-primary to-accent px-8 py-6 relative flex-shrink-0">
                <button @click="open = false; $wire.call('resetForm')"
                    class="absolute top-4 right-4 text-white/80 hover:text-white text-2xl transition p-2 rounded-lg glass-card">
                    <flux:icon name="x-mark" class="w-6 h-6 stroke-current" />
                </button>

                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <span
                        class="bg-linear-to-r from-zinc-900 to-zinc-800 flex items-center justify-center p-2 rounded-xl">
                        <flux:icon name='megaphone' class="w-7 h-7 stroke-white" />
                    </span>
                    {{ __('Send Announcement') }}
                </h2>
            </div>

            <!-- Form Content - Scrollable -->
            <div class="p-6 overflow-y-auto flex-1">
                <form wire:submit="save">
                    <div class="gap-4 grid grid-cols-1 md:grid-cols-2">

                        {{-- type --}}
                        <div class="w-full">
                            <x-ui.label value="Send To" class="mb-1" />
                            <x-ui.select wire:model="form.type">
                                @foreach ($types as $type)
                                    <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                                @endforeach
                            </x-ui.select>
                            <x-ui.input-error :messages="$errors->get('form.type')" />
                        </div>

                        {{-- Redirect Url --}}
                        <div class="w-full">
                            <x-ui.label value="Redirect / Action Url (Optional)" class="mb-1" />
                            <x-ui.input placeholder="swapy.gg" wire:model="form.action" type="url" />
                            <x-ui.input-error :messages="$errors->get('form.action')" />
                        </div>

                        {{-- title --}}
                        <div class="w-full md:col-span-2">
                            <x-ui.label value="Title" class="mb-1" />
                            <x-ui.input type="text" placeholder="Title" wire:model="form.title" />
                            <x-ui.input-error :messages="$errors->get('form.title')" />
                        </div>

                        {{-- Message --}}
                        <div class="w-full md:col-span-2">
                            <x-ui.label value="Message" class="mb-1" />
                            <x-ui.textarea placeholder="Message" wire:model="form.message" rows="2" />
                            <x-ui.input-error :messages="$errors->get('form.message')" />
                        </div>

                        {{-- Description --}}
                        <div class="w-full md:col-span-2">
                            <x-ui.label value="Description (Optional)" class="mb-1" />
                            <x-ui.textarea placeholder="Description" wire:model="form.description" rows="4" />
                            <x-ui.input-error :messages="$errors->get('form.description')" />
                        </div>

                        {{-- Additional Notes Section --}}
                        <div class="w-full md:col-span-2 border-t pt-4 mt-2">
                            <div class="flex items-center justify-between mb-3">
                                <x-ui.label value="Additional Information (Key-Value Pairs)" class="mb-0" />
                                <button type="button"
                                    @click="
                                        if (!additionalNotes || Array.isArray(additionalNotes)) {
                                            additionalNotes = {};
                                        }
                                        const tempKey = getNextKeyName(); 
                                        additionalNotes[tempKey] = ''; 
                                        tempKeys[tempKey] = tempKey;
                                        $wire.set('form.additional', additionalNotes);
                                        setTimeout(() => {
                                            const container = $el.closest('.overflow-y-auto');
                                            if (container) {
                                                container.scrollTop = container.scrollHeight;
                                            }
                                        }, 100);
                                    "
                                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary hover:bg-primary/90 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <span>Add Field</span>
                                </button>
                            </div>

                            {{-- Dynamic Additional Key-Value Pairs --}}
                            <div x-show="additionalNotes && Object.keys(additionalNotes).length > 0" class="space-y-3">
                                <template x-for="(value, key) in additionalNotes" :key="key">
                                    <div class="flex items-start gap-2"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95">

                                        {{-- Key Input --}}
                                        <div class="flex-1">
                                            <input type="text" placeholder="Additional Note Key"
                                                :value="tempKeys[key] !== undefined ? tempKeys[key] : key"
                                                @input="tempKeys[key] = $event.target.value"
                                                @blur="
                                                    const newKey = tempKeys[key]?.trim();
                                                    if (newKey && newKey !== key && !additionalNotes.hasOwnProperty(newKey)) {
                                                        const temp = {};
                                                        for (const [k, v] of Object.entries(additionalNotes)) {
                                                            if (k === key) {
                                                                temp[newKey] = v;
                                                                tempKeys[newKey] = newKey;
                                                                delete tempKeys[key];
                                                            } else {
                                                                temp[k] = v;
                                                            }
                                                        }
                                                        additionalNotes = temp;
                                                        $wire.set('form.additional', temp);
                                                    } else if (!newKey) {
                                                        tempKeys[key] = key;
                                                    }
                                                "
                                                class="w-full shadow-sm px-3 py-2 bg-transparent dark:bg-transparent dark:text-zinc-100 text-zinc-900 rounded-md border border-zinc-300 focus:border-accent focus:ring-accent focus:ring-1 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 bg-white text-zinc-900 placeholder-zinc-400 focus:outline-none focus:ring-offset-0" />
                                        </div>

                                        {{-- Value Input --}}
                                        <div class="flex-1">
                                            <input type="text" placeholder="Additional Note Value"
                                                :value="additionalNotes[key]"
                                                @input="
                                                    additionalNotes[key] = $event.target.value;
                                                    $wire.set('form.additional.' + key, $event.target.value);
                                                "
                                                class="w-full shadow-sm px-3 py-2 bg-transparent dark:bg-transparent dark:text-zinc-100 text-zinc-900 rounded-md border border-zinc-300 focus:border-accent focus:ring-accent focus:ring-1 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 bg-white text-zinc-900 placeholder-zinc-400 focus:outline-none focus:ring-offset-0" />
                                        </div>

                                        {{-- Remove Button --}}
                                        <button type="button"
                                            @click="
                                                const temp = {...additionalNotes};
                                                delete temp[key];
                                                delete tempKeys[key];
                                                additionalNotes = temp;
                                                $wire.set('form.additional', temp);
                                            "
                                            class="flex-shrink-0 p-2.5 bg-red-100 hover:bg-red-200 dark:bg-red-900/20 dark:hover:bg-red-900/40 text-red-600 dark:text-red-400 rounded-lg transition-colors duration-200 mt-0.5"
                                            title="Remove field">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>

                            <div x-show="!additionalNotes || Object.keys(additionalNotes).length === 0"
                                class="text-center py-6 text-zinc-500 dark:text-zinc-400 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border-2 border-dashed border-zinc-300 dark:border-zinc-700">
                                <svg class="w-10 h-10 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class="text-sm font-medium">No additional fields added yet</p>
                                <p class="text-xs mt-1">Click "Add Field" above to include custom key-value data</p>
                            </div>
                        </div>

                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-4 mt-6 pt-4 border-t">
                        <x-ui.button type="button" wire:click="resetForm" variant="tertiary" class="w-auto! py-2!">
                            <flux:icon name="x-circle"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                            <span wire:loading.remove wire:target="resetForm"
                                class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Reset') }}</span>
                            <span wire:loading wire:target="resetForm"
                                class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Resetting...') }}</span>
                        </x-ui.button>

                        <x-ui.button class="w-auto! py-2!" type="submit">
                            <flux:icon name="paper-airplane"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary"
                                wire:loading.remove wire:target="save" />
                            <span wire:loading.remove wire:target="save"
                                class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Send') }}</span>
                            <span wire:loading wire:target="save"
                                class="text-text-btn-primary group-hover:text-text-btn-secondary">
                                <svg class="animate-spin h-4 w-4 inline" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                {{ __('Sending...') }}
                            </span>
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

</div>
