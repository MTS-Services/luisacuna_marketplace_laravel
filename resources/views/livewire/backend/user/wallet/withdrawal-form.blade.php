<section>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/tinymce.css') }}">
    @endpush
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Add Withdrawal Method') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('user.wallet.withdrawal-methods', encrypt($method->id)) }}"
                    class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">
            <div class="mt-6 grid grid-cols-2 gap-5">
                <div class="w-full">
                    {{-- Label --}}
                    <x-ui.label :value="__('Account Name')" class="mb-1" />

                    {{-- Input --}}
                    <x-ui.input type="text" wire:model="account_name"
                        placeholder="{{ __('Enter your account name') }}"></x-ui.input>
                    <x-ui.input-error :messages="$errors->get('account_name')" />
                </div>
                @foreach (json_decode($method->required_fields, true) as $field)
                    <div class="w-full">
                        {{-- Dynamic Fields --}}
                        {{-- @foreach (json_decode($method->required_fields, true) as $fieldName => $fieldRules)
                            @php
                                $field = [
                                    'name' => $fieldName,
                                    'validation' => $fieldRules,
                                    'label' => Str::title(str_replace('_', ' ', $fieldName)),
                                    'input_type' => 'text',
                                    'placeholder' => 'Enter ' . Str::lower(str_replace('_', ' ', $fieldName)),
                                ];

                                // Detect input type from field name
                                if (Str::contains($fieldName, 'email')) {
                                    $field['input_type'] = 'email';
                                } elseif (Str::contains($fieldName, ['phone', 'mobile', 'number'])) {
                                    $field['input_type'] = 'tel';
                                }
                            @endphp

                            <div class="w-full">
                                <x-ui.label :value="$field['label']" class="mb-1" />

                                <x-ui.input type="{{ $field['input_type'] }}"
                                    wire:model="account_data.{{ Str::snake(Str::snake($field['name'])) }}"
                                    placeholder="{{ $field['placeholder'] }}" />

                                <x-ui.input-error :messages="$errors->get('account_data.' . Str::snake(Str::snake($field['name'])))" />
                            </div>
                        @endforeach --}}

                        {{-- Label --}}
                        <x-ui.label :value="$field['label']" class="mb-1" />

                        {{-- Dynamic Input --}}
                        @switch($field['input_type'])
                            @case('textarea')
                                <x-ui.textarea wire:model="account_data.{{ Str::snake(Str::snake($field['name'])) }}"
                                    placeholder="{{ $field['placeholder'] ?? '' }}"></x-ui.textarea>
                            @break

                            @case('select')
                                <x-ui.select wire:model="account_data.{{ Str::snake($field['name']) }}">
                                    <option value="">Select option</option>
                                    @foreach (explode(',', $field['options'] ?? '') as $option)
                                        <option value="{{ trim($option) }}">{{ trim($option) }}</option>
                                    @endforeach
                                </x-ui.select>
                            @break

                            @case('radio')
                                <div class="space-y-2">
                                    @foreach (explode(',', $field['options'] ?? '') as $option)
                                        <label class="flex items-center gap-2">
                                            <input type="radio" value="{{ trim($option) }}"
                                                wire:model="account_data.{{ Str::snake($field['name']) }}">
                                            <span>{{ trim($option) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @break

                            @case('checkbox')
                                <div class="space-y-2">
                                    @foreach (explode(',', $field['options'] ?? '') as $option)
                                        <label class="flex items-center gap-2">
                                            <input type="checkbox" value="{{ trim($option) }}"
                                                wire:model="account_data.{{ Str::snake($field['name']) }}">
                                            <span>{{ trim($option) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @break

                            @case('file')
                                <x-ui.input type="file" wire:model="account_data.{{ Str::snake($field['name']) }}" />
                            @break

                            @default
                                {{-- For dynamic fields --}}
                                <x-ui.input type="{{ $field['input_type'] }}"
                                    wire:model="account_data.{{ Str::snake($field['name']) }}" />
                                <x-ui.input-error :messages="$errors->get('account_data.' . Str::snake($field['name']))" />
                        @endswitch

                        {{-- Help Text --}}
                        @if (!empty($field['help_text']))
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $field['help_text'] }}
                            </p>
                        @endif

                        {{-- Error --}}
                        <x-ui.input-error :messages="$errors->get('account_data.' . Str::snake($field['name']))" />
                    </div>
                @endforeach
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
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Create') }}</span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Saving...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
