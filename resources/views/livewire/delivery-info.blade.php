<div>
    <flux:modal name="delivery-info" class="md:w-[26rem] bg-[#1B0C33]!" >
        <div class="space-y-5 ">

            {{-- Header --}}
            <flux:heading size="lg" class="font-semibold text-2xl text-white">
                {{ __('Delivery info') }}
            </flux:heading>

            {{-- ── Face to face trade (always visible, not selectable) ── --}}
            <div class="rounded-xl bg-[#FFFFFF0A] p-4 space-y-4">

                <div class="flex items-center gap-2.5">
                    <flux:icon.check-circle variant="solid" class="w-5 h-5 fill-violet-500 shrink-0" />
                    <flux:text class="font-semibold text-sm text-white">{{ __('Face to face trade') }}</flux:text>
                </div>

                {{-- Note to seller --}}
                <flux:field>
                    <flux:label class="text-white">
                        {{ __('Note to seller (Optional)') }}
                    </flux:label>
                    <x-ui.textarea wire:model="notes" placeholder="{{ __('Note to seller') }}" rows="3"
                        class="resize-none text-white! placeholder-white! bg-transparent!" />
                    <flux:error name="notes" />
                </flux:field>

                {{-- Email & Username --}}
                <div class="grid grid-cols-2 gap-3">
                    <flux:field>
                        <x-ui.input wire:model="email" placeholder="{{ __('Emails') }}" type="email" class="text-white! placeholder-white! bg-transparent!" />
                        <flux:error name="email" />
                    </flux:field>

                    <flux:field>
                        <x-ui.input wire:model="username" placeholder="{{ __('Usernames') }}" class="text-white! placeholder-white! bg-transparent!" />
                        <flux:error name="username" />
                    </flux:field>
                </div>
            </div>

            {{-- ── Gifting — toggle checkbox only ─────────────────────── --}}
            <div wire:click="$toggle('is_gifting')"
                class="rounded-xl border p-4 cursor-pointer transition-colors duration-200 flex items-center gap-2.5"
                :class="$wire.is_gifting ?
                    'border-violet-500 bg-violet-500/10 dark:bg-violet-500/10' :
                    'border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600'">
                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-colors"
                    :class="$wire.is_gifting ?
                        'border-violet-500 bg-violet-500' :
                        'border-zinc-400 dark:border-zinc-600'">
                    <template x-if="$wire.is_gifting">
                        <flux:icon.check class="w-3 h-3 text-white" />
                    </template>
                </div>
                <flux:text class="font-semibold text-sm text-white">{{ __('Gifting') }}</flux:text>
            </div>

            {{-- Submit --}}
            <flux:button wire:click="submit" wire:loading.attr="disabled" variant="primary"
                class="w-full !rounded-full">
                <span wire:loading.remove wire:target="submit" class="text-white">{{ __('Submit') }}</span>
                <span wire:loading wire:target="submit" class="text-white">{{ __('Saving…') }}</span>
            </flux:button>
        </div>
    </flux:modal>
</div>
