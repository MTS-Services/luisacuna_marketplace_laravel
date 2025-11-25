<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Tag Edit') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.gm.tag.index') }}" class="w-auto! py-2!">

                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}

                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">
            <!-- Fields -->

            <div class="mt-6 space-y-4  gap-5">

                <x-ui.file-input wire:model="form.icon" label="Icon" accept="image/*" :error="$errors->first('form.icon')"
                    hint="Upload a profile picture (Max: 1MB) height: 200px width: 200px" :existingFiles="$existingFile"
                    removeModel="form.remove_file" />

                <x-ui.input-error :messages="$errors->get('form.icon')" class="mt-2" />

            </div>

            <div class="mt-6 space-y-4 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <x-ui.label for="name" :value="__('Name')" required />
                    <x-ui.input id="name" type="text" class="mt-1 block w-full" wire:model="form.name"
                        placeholder=" Name" />
                    <x-ui.input-error :messages="$errors->get('form.name')" class="mt-2" />
                </div>

                <div>
                    <x-ui.label for="slug" :value="__('Slug')" required />
                    <x-ui.input id="slug" type="text" class="mt-1 block w-full" wire:model="form.slug"
                        placeholder="Slug" />
                    <x-ui.input-error :messages="$errors->get('form.slug')" class="mt-2" />
                </div>

                <div>
                    <x-ui.label for="text_color" :value="__('Text Color')" required />
                    <x-ui.input id="text_color" type="color" class="mt-1 block w-full" wire:model="form.text_color"
                        placeholder="Text Color" />
                    <x-ui.input-error :messages="$errors->get('form.text_color')" class="mt-2" />
                </div>

                <div>
                    <x-ui.label for="bg_color" :value="__('Bg Color')" required />
                    <x-ui.input id="bg_color" type="color" class="mt-1 block w-full" wire:model="form.bg_color"
                        placeholder="Bg Color" />
                    <x-ui.input-error :messages="$errors->get('form.bg_color')" class="mt-2" />
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
            </div>


            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:click.prevent="resetForm" variant="tertiary" class="w-auto! py-2!">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    <span wire:loading.remove wire:target="resetForm"
                        class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Reset') }}</span>
                    <span wire:loading wire:target="resetForm"
                        class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Reseting...') }}</span>
                </x-ui.button>

                <x-ui.button class="w-auto! py-2!" type="submit">
                    <span wire:loading.remove wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Updae ') }}</span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Updating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
