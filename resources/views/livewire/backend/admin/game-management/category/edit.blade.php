<section>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/ckEditor.css') }}">
    @endpush
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Category Edit') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.gm.category.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">

            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Icon') }}
                </h3>
                <x-ui.file-input wire:model="form.icon" label="Profile Picture" accept="image/*" :error="$errors->first('form.icon')"
                    hint="Upload a profile picture (Max: 1MB) height: 200px width: 200px" :existingFiles="$existingFile"
                    removeModel="form.remove_file" />

                @error('form.icon')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror

            </div>


            <!-- Add other form fields here -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">
                {{-- title --}}
                <div class="w-full">
                    <x-ui.label value="Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Name" id="name" wire:model="form.name" />
                    <x-ui.input-error :messages="$errors->get('form.name')" />
                </div>

                {{-- slug --}}
                <div class="w-full">
                    <x-ui.label value="Slug" class="mb-1" />
                    <x-ui.input type="text" placeholder="Slug" id="slug" wire:model="form.slug" />
                    <x-ui.input-error :messages="$errors->get('form.slug')" />
                </div>

                {{-- meta title --}}
                <div class="w-full">
                    <x-ui.label value="Meta Title" class="mb-1" />
                    <x-ui.input type="text" placeholder="Meta Title" id="meta_title" wire:model="form.meta_title" />
                    <x-ui.input-error :messages="$errors->get('form.meta_title')" />
                </div>

                {{-- status --}}
                <div class="w-full">
                    <x-ui.label value="Status" class="mb-1" />
                    <x-ui.select wire:model="form.status">

                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" />
                </div>
                {{-- Layout --}}
                <div class="w-full">
                    <x-ui.label value="Layout" class="mb-1" />
                    <x-ui.select wire:model="form.layout">

                        @foreach ($layouts as $layout)
                            <option value="{{ $layout['value'] }}">{{ $layout['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.layout')" />
                </div>


            </div>

            {{-- meta description --}}
            <div class="w-full mt-2">
                <x-ui.label value="Meta Description" class="mb-1" />
                <x-ui.text-editor model="form.meta_description" id="meta_description"
                    placeholder="Enter your main content here..." :height="350" />

                <x-ui.input-error :messages="$errors->get('form.meta_description')" />
            </div>
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:click.prevent="resetForm" type="danger" class="w-auto! py-2!" variant="tertiary">
                    <flux:icon name="x-circle" class="w-4 h-4 stroke-white" />
                    {{ __('Reset') }}
                </x-ui.button>

                <x-ui.button type="accent" class="w-auto! py-2!">
                    <span wire:loading.remove wire:target="save" class="text-white">{{ __('Update') }}</span>
                    <span wire:loading wire:target="save" class="text-white">{{ __('Updating...') }}</span>
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
