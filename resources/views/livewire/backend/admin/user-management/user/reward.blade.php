<div x-data="{ pointModalShow: @entangle('pointModalShow').live }" @point-modal-open.window="pointModalShow = true;" x-show="pointModalShow"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak
    class="fixed inset-0 h-screen z-30 bg-black/5 backdrop-blur-lg flex items-center justify-center">

    @if ($isLoading)
        <div class="bg-main/90 backdrop-blur-xl rounded-3xl p-10 max-w-md w-full shadow-2xl border border-white/10
               flex flex-col items-center justify-center gap-6"
            @click.away="pointModalShow = false">
            <!-- Spinner -->
            <div class="relative w-16 h-16">
                <div class="absolute inset-0 rounded-full border-4 border-white/10"></div>
                <div
                    class="absolute inset-0 rounded-full border-4 border-t-transparent
                       border-l-transparent border-r-zinc-400 border-b-zinc-200
                       animate-spin">
                </div>
            </div>

            <!-- Text -->
            <div class="text-center space-y-1">
                <p class="text-text-text-white font-semibold tracking-wide">
                    {{ __('Processing...') }}
                </p>
                <p class="text-text-muted text-sm animate-pulse">
                    {{ __('Please wait a moment…') }}
                </p>
            </div>
        </div>
    @else
        <div
            class="bg-main rounded-2xl pb-4 sm:pb-6 lg:pb-8 px-4 sm:px-6 lg:px-8 max-w-2xl w-full shadow-2xl max-h-[90vh] overflow-y-auto">

            <!-- Header Section -->
            <div
                class="flex items-center justify-between pt-4 sm:pt-6 lg:pt-8 pb-6 sticky top-0 z-20 bg-main/95 backdrop-blur border-b border-white/10 mb-5">
                <div>
                    <h2
                        class="text-text-text-white text-2xl md:text-3xl font-bold tracking-tight flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                        {{ __('Add Points') }}
                    </h2>
                </div>
                <button wire:click="closeModal" @click="pointModalShow = false"
                    class="text-text-muted hover:text-text-white hover:bg-slate-700/50 p-2 rounded-lg transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form wire:submit.prevent="submitPoints" class="space-y-6">

                <!-- User Selection -->
                <div class="glass-card rounded-xl p-6">
                    <label class="block text-text-white text-sm font-medium mb-3">
                        {{ __('Select Type') }}
                    </label>
                    <select wire:model="type"
                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-3 text-text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option class="bg-zinc-800" value="">{{ __('Choose a type') }}</option>
                        @foreach ($types as $type)
                            <option class="bg-zinc-800" value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="text-pink-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Points Amount -->
                <div class="glass-card rounded-xl p-6">
                    <label class="block text-text-white text-sm font-medium mb-3">
                        {{ __('Points Amount') }}
                    </label>
                    <input type="number" wire:model="points" min="1" step="1"
                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-3 text-text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="{{ __('Enter points amount') }}">
                    @error('points')
                        <p class="text-pink-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="glass-card rounded-xl p-6">
                    <label class="block text-text-white text-sm font-medium mb-3">
                        {{ __('Notes') }}
                    </label>
                    <textarea wire:model="notes" rows="4"
                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-3 text-text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        placeholder="{{ __('Enter reason for adding/deducting points') }}"></textarea>
                    @error('notes')
                        <p class="text-pink-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->

                <div class="flex items-center justify-end gap-4 mt-6">
                    <x-ui.button wire:click="closeModal" variant="tertiary" type="button" class="w-auto! py-2!">
                        <flux:icon name="x-circle"
                            class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                        {{ __('Cancel') }}
                    </x-ui.button>

                    <x-ui.button class="w-auto! py-2!" type="submit">
                        <span
                            class="text-text-btn-primary group-hover:text-text-btn-secondary">
                            {{ __('Submit') }}
                        </span>
                    </x-ui.button>
                </div>
            </form>

        </div>
    @endif

</div>
