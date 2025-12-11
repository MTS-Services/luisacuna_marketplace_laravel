<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Fee Settings') }}</h2>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">
            <!-- Seller Fee -->
            <div class="w-full col-span-2">
                <x-ui.label value="Seller Fee" class="mb-1" />
                <x-ui.input type="number" placeholder="seller fee" wire:model="form.seller_fee" />
                <x-ui.input-error :messages="$errors->get('form.seller_fee')" />
            </div>
            <!-- Seller Fee -->
            <div class="w-full col-span-2 mt-3">
                <x-ui.label value="Buyer Fee" class="mb-1" />
                <x-ui.input type="number" placeholder="buyer fee" wire:model="form.buyer_fee" />
                <x-ui.input-error :messages="$errors->get('form.buyer_fee')" />
            </div>
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:click="resetForm" variant="tertiary" class="w-auto! py-2! ">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Reset') }}
                </x-ui.button>

                <x-ui.button type="accent" class="w-auto! py-2!">
                    <span wire:loading.remove wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Update') }}</span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Updating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
