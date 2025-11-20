<!-- BLADE VIEW: resources/views/livewire/backend/admin/admin-management/role/create.blade.php -->

<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Role Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.am.role.index') }}" class="w-auto py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save" x-data="permissionManager()" @permission-update.window="updatePermissions($event.detail)"
            @init-permissions.window="initPermissions($event.detail)">

            <!-- Name Field -->
            <div>
                <x-ui.label for="name" :value="__('Name')" required />
                <x-ui.input id="name" type="text" class="mt-1 block w-full" wire:model="form.name"
                    placeholder="Enter role name" />
                <x-ui.input-error :messages="$errors->get('form.name')" class="mt-2" />
            </div>

            <!-- Permissions Header with Select All -->
            <div class="mt-8 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-text-black dark:text-text-white">{{ __('Select Permissions') }}
                    </h2>
                    <label class="flex items-center gap-2 cursor-pointer hover:text-blue-500 transition-colors">
                        <input type="checkbox" class="checkbox checkbox-sm checkbox-accent" @change="toggleSelectAll()"
                            :checked="allPermissionsSelected" />
                        <span class="text-sm font-medium">{{ __('Select All') }}</span>
                    </label>
                </div>
            </div>

            <!-- Permissions Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-3 3xl:grid-cols-4 gap-4">
                @forelse($permissions as $prefix => $permissionGroup)
                    <div class="glass-card rounded-lg p-5 border border-gray-200 dark:border-gray-700 transition-all duration-200 hover:border-blue-400 dark:hover:border-blue-600"
                        x-data="{ expanded: true }">

                        <!-- Prefix Header with Collapse Toggle -->
                        <label class="flex items-center gap-3 mb-4 cursor-pointer hover:opacity-80 transition-opacity">
                            <input type="checkbox" class="checkbox checkbox-md checkbox-accent prefix-checkbox"
                                data-prefix="{{ $prefix }}" @change="togglePrefix($event, '{{ $prefix }}')"
                                :checked="isPrefixChecked('{{ $prefix }}')" />
                            <span
                                class="font-bold text-sm uppercase tracking-wide text-gray-700 dark:text-gray-300 flex-1">
                                {{ $prefix }}
                            </span>
                            <button type="button" @click="expanded = !expanded"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': !expanded }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </button>
                        </label>

                        <!-- Permissions List -->
                        <div class="space-y-2 ml-6 relative after:absolute after:top-6 after:content-[''] after:h-[calc(100%-1.5rem)] after:w-0.5 after:bg-gradient-to-b after:from-gray-300 after:to-transparent after:dark:from-gray-600 after:-left-2"
                            x-show="expanded" x-transition>
                            @foreach ($permissionGroup as $permission)
                                <label
                                    class="flex items-center gap-3 py-2 px-2 rounded-md hover:bg-blue-50 dark:hover:bg-blue-900/20 cursor-pointer transition-colors group">
                                    <input type="checkbox"
                                        class="checkbox checkbox-xs checkbox-secondary permission-checkbox"
                                        data-prefix="{{ $prefix }}" name="form.permissions[]"
                                        value="{{ $permission->id }}" wire:model="form.permissions"
                                        @change="onPermissionChange('{{ $prefix }}')" />
                                    <span
                                        class="text-sm text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-gray-100 transition-colors">
                                        {{ $permission->name }}
                                    </span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 ml-auto">
                                        {{ $permission->description ?? '-' }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500 dark:text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5-4a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        {{ __('No permissions available') }}
                    </div>
                @endforelse
            </div>

            <!-- Selected Permissions Summary -->
            <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800"
                x-show="selectedCount > 0" x-transition>
                <p class="text-sm text-blue-900 dark:text-blue-100">
                    <span class="font-semibold" x-text="selectedCount"></span> {{ __('permission(s) selected') }}
                </p>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-8">
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

<script>
    function permissionManager() {
        return {
            allPermissionsSelected: false,
            selectedCount: 0,

            init() {
                this.updateAllStates();
                // Watch for external changes from Livewire
                this.$watch('$root', () => {
                    this.$nextTick(() => this.updateAllStates());
                }, {
                    deep: true
                });
            },

            updateAllStates() {
                this.updatePermissions();
                this.updateAllPrefixCheckboxes();
                this.updateSelectAllCheckbox();
            },

            // Update counts when permissions change
            updatePermissions() {
                const checkboxes = document.querySelectorAll('input[name="form.permissions[]"]');
                this.selectedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            },

            // Update individual prefix checkboxes based on their permissions
            updateAllPrefixCheckboxes() {
                const prefixCheckboxes = document.querySelectorAll('.prefix-checkbox');
                prefixCheckboxes.forEach(prefixCb => {
                    const prefix = prefixCb.getAttribute('data-prefix');
                    const permissionCheckboxes = document.querySelectorAll(
                        `.permission-checkbox[data-prefix="${prefix}"]`
                    );

                    const total = permissionCheckboxes.length;
                    const checked = Array.from(permissionCheckboxes).filter(cb => cb.checked).length;

                    // Update prefix checkbox state
                    prefixCb.checked = checked > 0 && checked === total;
                    prefixCb.indeterminate = checked > 0 && checked < total;
                });
            },

            // Update select all checkbox
            updateSelectAllCheckbox() {
                const allCheckboxes = document.querySelectorAll('input[name="form.permissions[]"]');
                const selectedCheckboxes = Array.from(allCheckboxes).filter(cb => cb.checked);

                this.allPermissionsSelected = allCheckboxes.length > 0 && selectedCheckboxes.length === allCheckboxes
                    .length;
            },

            // Check if all permissions in a prefix are selected
            isPrefixChecked(prefix) {
                const permissionCheckboxes = document.querySelectorAll(
                    `.permission-checkbox[data-prefix="${prefix}"]`
                );
                if (permissionCheckboxes.length === 0) return false;

                const checkedCount = Array.from(permissionCheckboxes).filter(cb => cb.checked).length;
                return checkedCount === permissionCheckboxes.length;
            },

            // Toggle all permissions
            toggleSelectAll() {
                const checkboxes = document.querySelectorAll('input[name="form.permissions[]"]');
                const shouldCheck = !this.allPermissionsSelected;

                checkboxes.forEach(cb => {
                    cb.checked = shouldCheck;
                    // Trigger change event for Livewire
                    cb.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                });

                this.updateAllStates();
            },

            // Toggle all permissions in a prefix
            togglePrefix(event, prefix) {
                event.preventDefault();

                const permissionCheckboxes = document.querySelectorAll(
                    `.permission-checkbox[data-prefix="${prefix}"]`
                );

                const anyChecked = Array.from(permissionCheckboxes).some(cb => cb.checked);
                const shouldCheck = !anyChecked;

                permissionCheckboxes.forEach(cb => {
                    cb.checked = shouldCheck;
                    // Trigger change event for Livewire
                    cb.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                });

                this.updateAllStates();
            },

            // Handle individual permission change
            onPermissionChange(prefix) {
                this.$nextTick(() => {
                    this.updateAllStates();
                });
            }
        };
    }
</script>
