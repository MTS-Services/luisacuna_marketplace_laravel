<div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Achievement Edit') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.rm.achievement.index') }}" class="w-auto py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">

            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Icon') }}
                </h3>
                <x-ui.file-input wire:model="form.icon" label="Icon" accept="image/*" :error="$errors->first('form.icon')"
                    hint="Upload a icon (Max: 2MB)" :existingFiles="$existingFile" removeModel="form.remove_icon" />
            </div>

            <!-- Fields -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">
                <div>
                    <x-ui.label for="rank_id" :value="__('Rank')" />
                    <x-ui.select id="rank_id" class="mt-1 block w-full" wire:model="form.rank_id">
                        <option value="">{{ __('Select Rank') }}</option>
                        @foreach ($ranks as $rank)
                            <option value="{{ $rank->id }}">{{ $rank->name }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.rank_id')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="achievement_type_id" :value="__('Achievement Type')" />
                    <x-ui.select id="achievement_type_id" class="mt-1 block w-full"
                        wire:model="form.achievement_type_id">
                        <option value="">{{ __('Select Achievement Type') }}</option>
                        @foreach ($achievementTypes as $achievementType)
                            <option value="{{ $achievementType->id }}">{{ $achievementType->name }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.achievement_type_id')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="title" :value="__('Title')" />
                    <x-ui.input id="title" type="text" class="mt-1 block w-full" wire:model="form.title"
                        placeholder="Enter title" />
                    <x-ui.input-error :messages="$errors->get('form.title')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="target_value" :value="__('Target Value')" />
                    <x-ui.input id="target_value" type="number" class="mt-1 block w-full"
                        wire:model="form.target_value" placeholder="Enter Target Value" />
                    <x-ui.input-error :messages="$errors->get('form.target_value')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="point_reward" :value="__('Point Reward')" />
                    <x-ui.input id="point_reward" type="number" class="mt-1 block w-full"
                        wire:model="form.point_reward" placeholder="Enter Point Reward" />
                    <x-ui.input-error :messages="$errors->get('form.point_reward')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="status" :value="__('Status')" />
                    <x-ui.select id="status" class="mt-1 block w-full" wire:model="form.status">
                        <option value="">{{ __('Select Status') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" class="mt-2" />
                </div>
            </div>

            {{-- description --}}
            <div class="w-full mt-2">
                <x-ui.label value="Description" class="mb-1" />
                <x-ui.text-editor model="form.description" id="text-editor-main-content"
                    placeholder="Enter your main content here..." :height="350" />

                <x-ui.input-error :messages="$errors->get('form.description')" />
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
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Update ') }}</span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Updating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</div>
