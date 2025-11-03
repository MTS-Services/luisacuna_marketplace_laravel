<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Game Category Edit') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.gm.category.index') }}">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="update">

            <!-- Add other form fields here -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">

                 <div>
                    <x-ui.label for="name" :value="__('Name')" required />
                    <x-ui.input id="name" type="text" class="mt-1 block w-full" wire:model="form.name"
                        placeholder="category name" />
                    <x-ui.input-error :messages="$errors->get('form.name')" class="mt-2" />
                </div>


                <div>
                    <x-ui.label for="status" :value="__('Status')" required />
                    <x-ui.select id="status" class="mt-1 block w-full" wire:model="form.status">
                        <option value="">{{ __('Select Status') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" class="mt-2" />
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea wire:model="form.description" id="" cols="30" rows="10"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600"></textarea>

                    @error('form.description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button href="{{ route('admin.gm.category.index') }}" type="danger" class="w-auto!">
                    <flux:icon name="x-circle" class="w-4 h-4 stroke-white" />
                    {{ __('Cancel') }}
                </x-ui.button>

                <x-ui.button type="accent" button class="w-auto!">
                    <span wire:loading.remove wire:target="update" class="text-white">Update Category</span>
                    <span wire:loading wire:target="update" class="text-white">Updating...</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
