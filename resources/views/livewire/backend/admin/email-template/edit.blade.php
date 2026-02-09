<section>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/tinymce.css') }}">
    @endpush
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Email Template Edit') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.email-template.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">

            <!-- Add other form fields here -->
            <div class="mt-6 space-y-4 grid grid-cols-1 gap-5">
                <div>
                    <x-ui.label for="name" :value="__('Variable')" required />

                    <div class="flex gap-2 mt-2">
                        @foreach ($variables as $item )
                            <div class="p-1 shadow-md dark:shadow-gray-800 ">
                                <div class="text-sx font-extralight">{{'{'.$item.'}'}}</div>
                            </div>
                        @endforeach
                       
                    </div>
                </div>

                <div>
                    <x-ui.text-editor model="form.content" id="text-editor-main-content"
                        placeholder="Enter your main content here..." :height="350" >
                    </x-ui.text-editor>
                </div>
                
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
</section>
