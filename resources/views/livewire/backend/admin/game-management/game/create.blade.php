<section>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/ckEditor.css') }}">
    @endpush
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Game Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.gm.game.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save" enctype="multipart/form-data">
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">

                {{-- Images --}}
                <div class="col-span-2">
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Logo') }}</x-ui.label>
                    <x-ui.file-input type="file" wire:model="form.logo"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                    <x-ui.input-error :messages="$errors->get('form.logo')" class="mt-2" />
                </div>

                {{-- Name --}}

                <div>
                    <x-ui.label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Name') }} <span class="text-red-500">*</span>
                    </x-ui.label>
                    <x-ui.input type="text" wire:model="form.name" placeholder="{{ __('Game Name') }}" id="name"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                    <x-ui.input-error :messages="$errors->get('form.name')" class="mt-2" />
                </div>

                {{-- Slug --}}

                <div>
                    <x-ui.label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Slug') }} <span class="text-red-500">*</span>
                    </x-ui.label>
                    <x-ui.input type="text" wire:model="form.slug" placeholder="{{ __('Slug') }}" id="slug"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                    <x-ui.input-error :messages="$errors->get('form.slug')" class="mt-2" />
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Category') }} <span class="text-red-500">*</span>
                    </label>
                    <x-ui.select wire:model="form.categories" name="categories[]" :multiple="true" :tags="true"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600 select2">
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach ($categories as $index => $value)
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.categories')" class="mt-2" />
                </div>
                {{-- Platform --}}
                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Platform') }} <span class="text-red-500">*</span>
                    </label>
                    <x-ui.select wire:model="form.platforms" :multiple="true" :tags="true"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                        <option value="">{{ __('Select Platform') }}</option>
                        @foreach ($platforms as $index => $value)
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.platforms')" class="mt-2" />
                </div>
                {{-- Server --}}
                {{-- <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Server') }} <span class="text-red-500">*</span>
                    </label>
                    <x-ui.select wire:model="form.servers" :multiple="true" :tags="true"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                        <option value="">{{ __('Select Server') }}</option>
                        @foreach ($servers as $index => $value)
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.servers')" class="mt-2" />
                </div> --}}
                {{-- Rarity --}}
                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Rarity') }} <span class="text-red-500">*</span>
                    </label>
                    <x-ui.select wire:model="form.rarities" :multiple="true" :tags="true"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                        <option value="">{{ __('Select Rarity') }}</option>
                        @foreach ($rarities as $index => $value)
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.rarities')" class="mt-2" />
                </div>
                {{-- Type --}}
                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Type') }} <span class="text-red-500">*</span>
                    </label>
                    <x-ui.select wire:model="form.types" :multiple="true" :tags="true"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                        <option value="">{{ __('Select Type') }}</option>
                        @foreach ($types as $index => $value)
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.types')" class="mt-2" />
                </div>
                {{-- Tag --}}
                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Tag') }} <span class="text-red-500">*</span>
                    </label>
                    <x-ui.select wire:model="form.tags" :multiple="true" :tags="true"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                        <option value="">{{ __('Select Tag') }}</option>
                        @foreach ($tags as $index => $value)
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.tags')" class="mt-2" />
                </div>

                {{-- Status --}}
                <div>
                    <x-ui.label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Status') }} <span class="text-red-500">*</span>
                    </x-ui.label>
                    <x-ui.select wire:model="form.status"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
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
                    <x-ui.text-editor model="form.meta_description" id="meta_description"
                        placeholder="Enter your main content here..." :height="350" />
                    <x-ui.input-error :messages="$errors->get('form.meta_description')" class="mt-2" />
                </div>

                <div class="col-span-2">
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Meta Keywords') }}</x-ui.label>
                    {{-- <x-ui.textarea wire:model="form.meta_keywords" rows="2"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600"></x-ui.textarea> --}}
                    <x-ui.input type="text" wire:model="form.meta_keywords"
                        placeholder="{{ __('Meta Keywords') }}"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                    <x-ui.input-error :messages="$errors->get('form.meta_keywords')" class="mt-2" />
                </div>

            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:click.prevent="resetForm" type="danger" class="w-auto! py-2!" button
                    variant="tertiary">
                    <flux:icon name="x-circle" class="w-4 h-4 stroke-white" />
                    {{ __('Reset') }}
                </x-ui.button>

                <x-ui.button type="accent" button class="w-auto! py-2!">
                    <span wire:loading.remove wire:target="save" class="text-white">{{ __('Create Game') }}</span>
                    <span wire:loading wire:target="save" class="text-white">{{ __('Creating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>

    @push('scripts')
        {{-- Auto slug script --}}
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
