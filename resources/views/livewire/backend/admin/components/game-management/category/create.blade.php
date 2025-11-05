<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Game Category Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.gm.category.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">

            <!-- Add other form fields here -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="form.name"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>



                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Status') }} <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="form.status"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                        <option value="">{{__('Select Status')}}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </select>
                    @error('form.status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Description') }} <span class="text-red-500">*</span>
                    </label>
                    <textarea wire:model="form.description" id="" cols="30" rows="10"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600"></textarea>

                    @error('form.description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


            </div>

            <!-- Form Actions -->



              <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:click="resetFrom" variant="tertiary"
                    class="w-auto! py-2! ">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Reset') }}
                </x-ui.button>

                <x-ui.button type="accent" button>
                    <span wire:loading.remove wire:target="save" class="text-white">{{__('Create Category')}}</span>
                    <span wire:loading wire:target="save" class="text-white">{{__('Creating...')}}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
