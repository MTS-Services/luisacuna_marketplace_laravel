<form wire:submit="save">
    <div class="w-full">
        <x-ui.label for="name" :value="__('Name')" />
        <x-ui.input id="name" type="text" class="mt-1 block w-full" wire:model="form.name"
            placeholder="Enter name" />
        <x-ui.input-error :messages="$errors->get('form.name')" class="mt-2" />
    </div>


    {{-- is_active --}}
    <div class="w-full text-left! mt-2">
        <input type="checkbox" wire:model="form.is_active" />
        <x-ui.label value="Is Featured" class="mb-1 inline" />
        <x-ui.input-error :messages="$errors->get('form.is_active')" />
    </div>

    <!-- Form Actions -->
    <div class="flex items-center justify-end gap-4 mt-6">
        <x-ui.button wire:click="resetForm" variant="tertiary" class="w-auto! py-2!">
            <flux:icon name="x-circle" class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
            <span wire:loading.remove wire:target="resetForm"
                class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Reset') }}</span>
            <span wire:loading wire:target="resetForm"
                class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Reseting...') }}</span>
        </x-ui.button>

        <x-ui.button class="w-auto! py-2!" type="submit">
            <span wire:loading.remove wire:target="save"
                class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Create ') }}</span>
            <span wire:loading wire:target="save"
                class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Saving...') }}</span>
        </x-ui.button>
    </div>
</form>
