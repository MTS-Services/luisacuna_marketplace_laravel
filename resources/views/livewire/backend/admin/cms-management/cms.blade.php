<section>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/tinymce.css') }}">
    @endpush
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
             <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ $typeEnum->label() }}</h2>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">

            {{-- meta description --}}
            <div class="w-full mt-2">
                <x-ui.label value="Content" class="mb-1" />
                <x-ui.text-editor model="form.content" id="meta_description"
                    placeholder="Enter your main content here..." :height="350" />

                <x-ui.input-error :messages="$errors->get('form.content')" />
            </div>
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:click="resetFrom" variant="tertiary" class="w-auto! py-2! ">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Reset') }}
                </x-ui.button>

                <x-ui.button type="accent" class="w-auto! py-2!">
                    <span wire:loading.remove wire:target="save" class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Update') }}</span>
                    <span wire:loading wire:target="save" class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Updating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
