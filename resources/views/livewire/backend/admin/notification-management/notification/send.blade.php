<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Notification Send') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.nm.notification.index') }}">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">



            <!-- Add other form fields here -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">

                {{-- status --}}
                <div class="w-full col-span-2">
                    <x-ui.label value="Send To" class="mb-1" />
                    <x-ui.select wire:model="form.type">
                        @foreach ($types as $type)
                            <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.type')" />
                </div>

                {{-- title --}}
                <div class="w-full col-span-2">
                    <x-ui.label value="Title" class="mb-1" />
                    <x-ui.input type="text" placeholder="Title" wire:model="form.title" />
                    <x-ui.input-error :messages="$errors->get('form.title')" />
                </div>

                {{-- Message --}}
                <div class="w-full col-span-2">
                    <x-ui.label value="Message" class="mb-1" />
                    <x-ui.input type="text" placeholder="Message" wire:model="form.message" />
                    <x-ui.input-error :messages="$errors->get('form.message')" />
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
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Send ') }}</span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Sending...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
