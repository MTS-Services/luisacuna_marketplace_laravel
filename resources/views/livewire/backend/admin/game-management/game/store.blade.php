<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Game Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.gm.game.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save" enctype="multipart/form-data">
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">

                <div>
                    <x-ui.label class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Logo') }}
                        <small>{{ __('(400x400)') }}</small></x-ui.label>
                    <x-ui.file-input type="file" wire:model="form.logo" :existingFiles="$existing_logo"
                        removeModel="form.remove_logo" accept="image/*" />
                    <x-ui.input-error :messages="$errors->get('form.logo')" class="mt-2" />
                </div>

                <div>
                    <x-ui.label class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Banner') }}
                        <small>{{ __('(1000x400)') }}</small></x-ui.label>
                    <x-ui.file-input type="file" wire:model="form.banner" :existingFiles="$existing_banner"
                        removeModel="form.remove_banner" accept="image/*" />
                    <x-ui.input-error :messages="$errors->get('form.banner')" class="mt-2" />
                </div>

                <div>
                    <x-ui.label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Name') }} <span class="text-red-500">*</span>
                    </x-ui.label>
                    <x-ui.input type="text" wire:model.live="form.name" placeholder="{{ __('Game Name') }}"
                        id="name"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                    <x-ui.input-error :messages="$errors->get('form.name')" class="mt-2" />
                </div>

                <div>
                    <x-ui.label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Slug') }} <span class="text-red-500">*</span>
                    </x-ui.label>
                    <x-ui.input type="text" wire:model.live="form.slug" placeholder="{{ __('Slug') }}"
                        id="slug" pattern="^[a-zA-Z0-9-]+$"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                    <x-ui.input-error :messages="$errors->get('form.slug')" class="mt-2" />
                </div>

                <div>
                    <x-ui.label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Status') }} <span class="text-red-500">*</span>
                    </x-ui.label>
                    <x-ui.select wire:model="form.status"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600 select2">
                        <option value="">{{ __('Select Status') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" class="mt-2" />
                </div>
                {{-- Description --}}
                <div class="col-span-2">
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Description') }}</x-ui.label>
                    <x-ui.text-editor model="form.description" id="description" placeholder="Enter game description..."
                        :height="350" />
                    <x-ui.input-error :messages="$errors->get('form.description')" class="mt-2" />
                </div>

                {{-- SEO Fields --}}
                <div class="col-span-2">
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Meta Title') }}</x-ui.label>
                    <x-ui.input type="text" wire:model="form.meta_title" placeholder="{{ __('Meta Title') }}"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                    <x-ui.input-error :messages="$errors->get('form.meta_title')" class="mt-2" />
                </div>

                <div class="col-span-2">
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Meta Description') }}</x-ui.label>
                    <x-ui.textarea model="form.meta_description" id="meta_description"
                        placeholder="Enter your main content here..." :height="350" />
                    <x-ui.input-error :messages="$errors->get('form.meta_description')" class="mt-2" />
                </div>

                <div class="col-span-2" x-data="{}">
                    <x-ui.label class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Meta Keywords') }}
                        <span class="text-text-muted font-normal">({{ __('comma separated') }})</span></x-ui.label>
                    {{-- <x-ui.textarea wire:model="form.meta_keywords" rows="2"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600"></x-ui.textarea> --}}
                    <x-ui.input wire:model="form.meta_keywords" placeholder="{{ __('Example: Keyword 1, Keyword 2') }}"
                        multiple class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />

                    <div x-show="$wire.form.meta_keywords" class="mt-2 flex flex-wrap gap-1">
                        <template x-for="value in $wire.form.meta_keywords.split(',').map(v => v.trim()).filter(v => v)"
                            :key="value">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300"
                                x-text="value"></span>
                        </template>
                    </div>

                    <x-ui.input-error :messages="$errors->get('form.meta_keywords')" class="mt-2" />
                </div>

            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4 mt-4">
                <x-ui.button wire:click="resetForm" variant="tertiary" class="w-auto! py-2!">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    <span wire:loading.remove wire:target="resetForm"
                        class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Reset') }}</span>
                    <span wire:loading wire:target="resetForm"
                        class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Reseting...') }}</span>
                </x-ui.button>

                <x-ui.button type="accent" button class="w-auto! py-2!">
                    <span wire:loading.remove wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Next Step') }}</span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Saving...') }}</span>
                    <flux:icon wire:loading.remove wire:target="save"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary"
                        name="arrow-right" />
                    <flux:icon wire:loading wire:target="save"
                        class="w-4 h-4 animate-spin stroke-text-btn-primary group-hover:stroke-text-btn-secondary"
                        name="arrow-path" />
                </x-ui.button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                document.getElementById('name').addEventListener('input', function() {
                    let slug = this.value
                        .toLowerCase()
                        .trim()
                        .replace(/\s+/g, '-')
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                    document.getElementById('slug').value = slug;

                    document.getElementById('slug').dispatchEvent(new Event('input'));
                });
            })
        </script>
    @endpush

</section>
