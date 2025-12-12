<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Banner Edit') }}</h2>
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2">
                    <x-ui.button href="{{ route('admin.bm.banner.index') }}" class="w-auto! py-2!">
                        <flux:icon name="arrow-left"
                            class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                        {{ __('Back') }}
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">
            <!-- Add other form fields here -->
               <div class="grid grid-cols-1 xl:grid-cols-1 gap-6">


            <div class="xl:col-span-2 space-y-6">


                <div class="glass-card rounded-2xl p-6 shadow-lg">
                    

                    <div class="grid grid-cols-1 md:grid-cols-1 gap-5">


                          <div class="w-full ">
                                <x-ui.file-input wire:model="form.image" label="Banner Image" accept="image/*" :error="$errors->first('form.image')"
                                    hint="Upload a profile picture (Max: 2MB)" :existingFiles="$existingFile" removeModel="form.remove_file" />
                          </div>
                          
                          <div class="w-full ">
                                <x-ui.file-input wire:model="form.mobile_image" label="Banner Image (Mobile Device)" accept="image/*" :error="$errors->first('form.mobile_image')"
                                    hint="Upload a profile picture (Max: 2MB)" :existingFiles="$existingFileMobile" removeModel="form.remove_file_mobile" />
                          </div>

                        <div>
                            <x-ui.label>
                                {{ __('Banner Title') }}
                                <span class="text-error">*</span>
                            </x-ui.label>
                            <x-ui.input type="text" wire:model="form.title" placeholder="{{ __('Title Here') }}"
                                class="mt-2" />
                            <x-ui.input-error :messages="$errors->get('form.title')" class="mt-1" />
                        </div>

                        <div>
                            <x-ui.label>
                                {{ __('Description') }}

                            </x-ui.label>
                            <x-ui.textarea wire:model="form.content" placeholder="{{ __('Description here') }}"
                                class="mt-2" rows="4" />

                            <x-ui.input-error :messages="$errors->get('form.content')" class="mt-1" />
                        </div>
                        <div>
                            <x-ui.label>
                                {{ __('Button Label') }}

                            </x-ui.label>
                            <x-ui.input type="text" wire:model="form.action_title" placeholder="{{ __('Url Label') }}"
                                class="mt-2" />
                            <x-ui.input-error :messages="$errors->get('form.action_title')" class="mt-1" />
                        </div>
                        <div>
                            <x-ui.label>
                                {{ __('Button Link') }}

                            </x-ui.label>
                            <x-ui.input type="text" wire:model="form.action_url" placeholder="{{ __('Link url') }}"
                                class="mt-2" />
                            <x-ui.input-error :messages="$errors->get('form.action_url')" class="mt-1" />
                        </div>

                        <div>
                            <x-ui.label>
                                {{ __('Link Behaviour') }}

                            </x-ui.label>
                            <x-ui.select wire:model="form.target" class="mt-2">

                                <option value="_self" {{ $data->target  == '_self' ? 'selected' : ''}} >{{ __('Same Tab') }}</option>
                                <option value="_blank" {{ $data->target  != '_self' ? 'selected' : ''}} >{{ __('New Tab') }}</option>
                                
                            </x-ui.select>
                            <x-ui.input-error :messages="$errors->get('form.target')" class="mt-1" />
                        </div>

                        <div>
                            <x-ui.label>

                                {{ __('Status') }}

                            </x-ui.label>
                            <x-ui.select wire:model="form.status" class="mt-2">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status['value'] }}" {{ $status['value'] == $data->status->value  ? 'selected' : ''}} >{{ $status['label'] }}</option>
                                @endforeach
                            </x-ui.select>
                            <x-ui.input-error :messages="$errors->get('form.status')" class="mt-1" />
                        </div>
                    </div>
                </div>


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
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Update ') }}</span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Updating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
