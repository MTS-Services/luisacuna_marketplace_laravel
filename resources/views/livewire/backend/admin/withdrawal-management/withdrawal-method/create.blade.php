<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Withdrawal Method Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.wm.method.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 mb-6" x-data="fieldBuilder()">
        <form wire:submit.prevent="save">
            <div class="mt-6 space-y-4 grid grid-cols-3 gap-5">
                <div class="w-full">
                    <x-ui.label value="Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Name" wire:model="form.name" />
                    <x-ui.input-error :messages="$errors->get('form.name')" />
                </div>

                <div class="w-full">
                    <x-ui.label value="Code" class="mb-1" />
                    <x-ui.input type="text" placeholder="Code" wire:model="form.code" />
                    <x-ui.input-error :messages="$errors->get('form.code')" />
                </div>

                <div class="w-full">
                    <x-ui.label value="Minimum Amount" class="mb-1" />
                    <x-ui.input type="number" placeholder="Minimum Amount" wire:model="form.min_amount" />
                    <x-ui.input-error :messages="$errors->get('form.min_amount')" />
                </div>

                <div class="w-full">
                    <x-ui.label value="Maximum Amount" class="mb-1" />
                    <x-ui.input type="number" placeholder="Maximum Amount" wire:model="form.max_amount" />
                    <x-ui.input-error :messages="$errors->get('form.max_amount')" />
                </div>

                <div class="w-full">
                    <x-ui.label value="Processing Time" class="mb-1" />
                    <x-ui.input type="text" placeholder="Processing Time" wire:model="form.processing_time" />
                    <x-ui.input-error :messages="$errors->get('form.processing_time')" />
                </div>

                <div class="w-full">
                    <x-ui.label value="Fee Type Select" class="mb-1" />
                    <x-ui.select wire:model="form.fee_type">
                        <option value="">{{ __('Select Fee Type') }}</option>
                        @foreach ($fee_types as $type)
                            <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.fee_type')" />
                </div>

                <div class="w-full">
                    <x-ui.label value="Fee Amount" class="mb-1" />
                    <x-ui.input type="number" placeholder="Fee Amount" wire:model="form.fee_amount" />
                    <x-ui.input-error :messages="$errors->get('form.fee_amount')" />
                </div>

                <div class="w-full">
                    <x-ui.label value="Fee Percentage" class="mb-1" />
                    <x-ui.input type="number" placeholder="Fee Percentage" wire:model="form.fee_percentage" />
                    <x-ui.input-error :messages="$errors->get('form.fee_percentage')" />
                </div>

                <div class="w-full">
                    <x-ui.label value="Status Select" class="mb-1" />
                    <x-ui.select wire:model="form.status">
                        <option value="">{{ __('Select Status') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" />
                </div>

                <div class="w-full col-span-3">
                    <x-ui.label value="Description" class="mb-1" />
                    <x-ui.textarea type="text" placeholder="Description" wire:model="form.description" />
                    <x-ui.input-error :messages="$errors->get('form.description')" />
                </div>
            </div>

            <!-- Dynamic Required Fields Section with Alpine.js -->
            <div class="required_fields mt-8">
                <div class="border-t pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-text-black dark:text-text-white">
                            {{ __('Required Fields Configuration') }}
                        </h3>
                        <x-ui.button type="button" @click="addField" class="w-auto! py-2!">
                            <flux:icon name="plus"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            {{ __('Add Field') }}
                        </x-ui.button>
                    </div>

                    <!-- Hidden input to sync with Livewire -->
                    <input type="hidden" x-model="JSON.stringify(fields)" wire:model="form.required_fields" />

                    <template x-if="fields.length > 0">
                        <div class="space-y-6">
                            <template x-for="(field, index) in fields" :key="field.id">
                                <div class="border rounded-lg p-4 bg-gray-50 dark:bg-gray-800" x-data="{ showOptions: ['select', 'radio', 'checkbox'].includes(field.input_type) }">

                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="font-medium text-text-black dark:text-text-white">
                                            {{ __('Field') }} #<span x-text="index + 1"></span>
                                        </h4>
                                        <x-ui.button variant="tertiary" type="button" @click="removeField(index)"
                                            class="w-auto! py-2!">
                                            <flux:icon name="trash"
                                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                                        </x-ui.button>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <!-- Label Name -->
                                        <div class="w-full">
                                            <x-ui.label value="Label Name" class="mb-1" />
                                            <x-ui.input type="text" x-model="field.label"
                                                placeholder="e.g., Account Number" />
                                        </div>

                                        <!-- Field Name -->
                                        <div class="w-full">
                                            <x-ui.label value="Field Name" class="mb-1" />
                                            <x-ui.input type="text" x-model="field.name"
                                                placeholder="e.g., account_number" />
                                        </div>

                                        <!-- Input Type -->
                                        <div class="w-full">
                                            <x-ui.label value="Input Type" class="mb-1" />
                                            <x-ui.select x-model="field.input_type"
                                                @change="showOptions = ['select', 'radio', 'checkbox'].includes($event.target.value)">
                                                <option value="">{{ __('Select Type') }}</option>
                                                <option value="text">Text</option>
                                                <option value="email">Email</option>
                                                <option value="number">Number</option>
                                                <option value="tel">Phone</option>
                                                <option value="url">URL</option>
                                                <option value="date">Date</option>
                                                <option value="time">Time</option>
                                                <option value="datetime-local">DateTime</option>
                                                <option value="password">Password</option>
                                                <option value="textarea">Textarea</option>
                                                <option value="select">Select Dropdown</option>
                                                <option value="radio">Radio Button</option>
                                                <option value="checkbox">Checkbox</option>
                                                <option value="file">File Upload</option>
                                            </x-ui.select>
                                        </div>

                                        <!-- Validation Type -->
                                        <div class="w-full">
                                            <x-ui.label value="Validation" class="mb-1" />
                                            <x-ui.select x-model="field.validation">
                                                <option value="required">Required</option>
                                                <option value="optional">Optional</option>
                                            </x-ui.select>
                                        </div>

                                        <!-- Placeholder -->
                                        <div class="w-full col-span-2">
                                            <x-ui.label value="Placeholder" class="mb-1" />
                                            <x-ui.input type="text" x-model="field.placeholder"
                                                placeholder="Enter placeholder text" />
                                        </div>

                                        <!-- Options for Select/Radio/Checkbox -->
                                        <div class="w-full col-span-2" x-show="showOptions"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 transform scale-95"
                                            x-transition:enter-end="opacity-100 transform scale-100">
                                            <x-ui.label value="Options (comma separated)" class="mb-1" />
                                            <x-ui.textarea x-model="field.options"
                                                placeholder="e.g., Option 1, Option 2, Option 3"></x-ui.textarea>
                                            <small class="text-gray-500">Enter options separated by commas</small>
                                        </div>
                                        <!-- Min/Max for Number inputs -->
                                        <template x-if="field.input_type === 'number'">
                                            <div class="w-full col-span-2 grid grid-cols-2 gap-4">
                                                <div class="w-full">
                                                    <x-ui.label value="Min Value" class="mb-1" />
                                                    <x-ui.input type="number" x-model="field.min"
                                                        placeholder="Minimum value" />
                                                </div>
                                                <div class="w-full">
                                                    <x-ui.label value="Max Value" class="mb-1" />
                                                    <x-ui.input type="number" x-model="field.max"
                                                        placeholder="Maximum value" />
                                                </div>
                                            </div>
                                        </template>

                                        <!-- Help Text -->
                                        <div class="w-full col-span-2">
                                            <x-ui.label value="Help Text" class="mb-1" />
                                            <x-ui.textarea type="text" x-model="field.help_text"
                                                placeholder="Additional help text for users" />
                                            <small class="text-gray-500">Additional help text for users</small>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                    <template x-if="fields.length === 0">
                        <div class="text-center py-8 text-gray-500">
                            <p>{{ __('No required fields added yet. Click "Add Field" to create custom fields.') }}</p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button @click="resetFields" variant="tertiary" type="button" class="w-auto! py-2!">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Reset Fields') }}
                </x-ui.button>

                <x-ui.button wire:click="resetForm" variant="tertiary" type="button" class="w-auto! py-2!">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Reset All') }}
                </x-ui.button>

                <x-ui.button class="w-auto! py-2!" type="submit" @click="syncFields">
                    <span wire:loading.remove wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">
                        {{ __('Create Withdrawal Method') }}
                    </span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">
                        {{ __('Creating...') }}
                    </span>
                </x-ui.button>
            </div>
        </form>
    </div>

    <script>
        function fieldBuilder() {
            return {
                fields: [],
                fieldCounter: 0,

                init() {
                    // Initialize from Livewire if editing
                    const existingFields = @json($form->required_fields ?? []);
                    if (existingFields && existingFields.length > 0) {
                        this.fields = existingFields.map((field, idx) => ({
                            id: this.fieldCounter++,
                            ...field
                        }));
                    }
                },

                addField() {
                    this.fields.push({
                        id: this.fieldCounter++,
                        label: '',
                        name: '',
                        input_type: 'text',
                        validation: 'required',
                        placeholder: '',
                        options: '',
                        help_text: '',
                        readonly: false,
                        disabled: false,
                        min: null,
                        max: null,
                    });
                },

                removeField(index) {
                    if (confirm('Are you sure you want to remove this field?')) {
                        this.fields.splice(index, 1);
                    }
                },

                resetFields() {
                    if (confirm('Are you sure you want to reset all fields?')) {
                        this.fields = [];
                        this.fieldCounter = 0;
                    }
                },

                syncFields() {
                    // Sync fields with Livewire before submit
                    this.$wire.set('form.required_fields', this.fields);
                }
            }
        }
    </script>
</section>
