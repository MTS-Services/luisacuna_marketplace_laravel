<div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Rank Edit') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.rm.rank.index') }}" class="w-auto py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
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
                    <x-ui.file-input wire:model="form.icon" label="Icon" accept="image/*" :error="$errors->first('form.icon')"
                    hint="Upload a icon (Max: 2MB)" :existingFiles="$existingFile" removeModel="form.remove_icon" />
            </div>


            <!-- Fields -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">
                <div>
                    <x-ui.label for="name" :value="__('Name')" />
                    <x-ui.input id="name" type="text" class="mt-1 block w-full" wire:model="form.name"
                        placeholder="Enter name" />
                    <x-ui.input-error :messages="$errors->get('form.name')" class="mt-2" />
                </div>


                {{-- slug --}}
                <div class="w-full">
                    <x-ui.label value="Slug" class="mb-1" />
                    <x-ui.input type="text" placeholder="Slug" id="slug" wire:model="form.slug" />
                    <x-ui.input-error :messages="$errors->get('form.slug')" />
                </div>

                <div>
                    <x-ui.label for="maximum_points" :value="__('Maximum Points')" />
                    <x-ui.input id="maximum_points" type="number" class="mt-1 block w-full"
                        wire:model="form.maximum_points" placeholder="Enter maximum points" />
                    <x-ui.input-error :messages="$errors->get('form.maximum_points')" class="mt-2" />
                </div>

                <div>
                    <x-ui.label for="minimum_points" :value="__('Minimum Points')" />
                    <x-ui.input id="minimum_points" type="number" class="mt-1 block w-full"
                        wire:model="form.minimum_points" placeholder="Enter minimum points" />
                    <x-ui.input-error :messages="$errors->get('form.minimum_points')" class="mt-2" />
                </div>

                <div>
                    <x-ui.label for="status" :value="__('Status')" />
                    <x-ui.select id="status" class="mt-1 block w-full" wire:model="form.status">
                        <option value="">{{ __('Select Status') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" class="mt-2" />
                </div>
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

    @push('scripts')
        {{-- Auto slug script --}}
        <script>
            document.getElementById('name').addEventListener('input', function() {
                let slug = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/\s+/g, '-');
                document.getElementById('slug').value = slug;

                document.getElementById('slug').dispatchEvent(new Event('input'));
            });
        </script>
    @endpush
</div>
