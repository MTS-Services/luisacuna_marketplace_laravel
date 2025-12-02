<div>
    {{-- Toast Notifications --}}
    @if (session()->has('success'))
        <div class="toast toast-top toast-center z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4">
            <div class="alert alert-success shadow-2xl border border-success/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="toast toast-top toast-center z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4">
            <div class="alert alert-error shadow-2xl border border-error/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="relative overflow-hidden glass-card rounded-2xl p-6 lg:p-8 mb-6 shadow-xl">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-secondary/5"></div>
        <div
            class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
        </div>

        <div class="relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-primary/10 rounded-xl">
                        <flux:icon name="cog-8-tooth" class="h-8 w-8 stroke-primary" />
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-text-primary">{{ __('Manage Banners') }}</h1>
                        {{-- <p class="text-text-secondary text-sm mt-1">{{ __('Manage Banners') }}
                        </p> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 xl:grid-cols-1 gap-6">

            {{-- Main Content --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- Application Identity --}}
                <div class="glass-card rounded-2xl p-6 shadow-lg">
                    

                    <div class="grid grid-cols-1 md:grid-cols-1 gap-5">


                          <div class="w-full ">
                                <x-ui.file-input wire:model="form.image" label="Banner Image" accept="image/*" :error="$errors->first('form.avatar')"
                                    hint="Upload a profile picture (Max: 2MB)" :existingFiles="$existingFile" removeModel="form.remove_file" />
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

        {{-- Action Bar --}}
        <div class="mt-8">
            <div class="glass-card rounded-2xl p-5 shadow-xl border border-primary/20">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="hidden sm:flex items-center gap-3 px-4 py-2 bg-info/10 rounded-xl">
                        <flux:icon name="information-circle" class="h-5 w-5 stroke-info" />
                        <span class="text-sm font-medium text-info">{{ __('Changes auto-save to .env file') }}</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <x-ui.button type="button" wire:click="resetForm" class="w-fit py-2! text-nowrap"
                            variant="tertiary">
                            {{-- <flux:icon name="arrow-path"
                                class="h-5 w-5 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                            {{ __('Reset') }} --}}
                            <span wire:loading.remove wire:target="resetForm"
                                class="flex items-center gap-2 text-text-btn-primary group-hover:text-text-btn-tertiary">
                                <flux:icon name="arrow-path"
                                    class="h-5 w-5 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                                {{ __('Reset') }}
                            </span>
                            <span wire:loading wire:target="resetForm"
                                class="flex items-center gap-2 text-text-btn-primary group-hover:text-text-btn-tertiary">
                                <flux:icon name="arrow-path"
                                    class="h-5 w-5 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary animate-spin" />
                                {{ __('Resetting...') }}
                            </span>
                        </x-ui.button>

                        <x-ui.button type="submit" wire:loading.attr="disabled" wire:target="save"
                            class="w-fit py-2! text-nowrap">
                            <span wire:loading.remove wire:target="save"
                                class="flex items-center gap-2 text-text-btn-primary group-hover:text-text-btn-secondary">
                                <flux:icon name="save"
                                    class="h-5 w-5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                                {{ __('Save Changes') }}
                            </span>
                            <span wire:loading wire:target="save"
                                class="flex items-center gap-2 text-text-btn-primary group-hover:text-text-btn-secondary">
                                <span class="loading loading-spinner loading-sm"></span>
                                {{ __('Saving...') }}
                            </span>
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
