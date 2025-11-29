@props([
    'icon' => 'folder', // Default parent icon
    'name' => 'Multi Navlink',
    'boxicon' => false,
    'active' => '',
    'page_slug' => '',
    'items' => [], // Array of nav items (single, dropdown, or multi-dropdown)
    'type' => 'dropdown', // 'dropdown' or 'single' - determines if main item is clickable
    'route' => '', // Route for main item when type is 'single'
    'permission' => '',
])

@php
    // Default icons for different levels
    $defaultParentIcon = $icon ?: 'folder';
    $defaultSubitemIcon = 'file';
    $defaultMultiSubitemIcon = 'circle';

    // Filter items based on permissions
    $filteredItems = [];
    $mainPermissions = [];

    foreach ($items as $item) {
        $hasPermission = true;

        // Check permission for the item itself
        if (isset($item['permission']) && !empty($item['permission'])) {
            $hasPermission = auth()->user()->can($item['permission']);
            $mainPermissions[] = $item['permission'];
        }

        // If this is a multi-dropdown item with subitems, filter subitems
        if (isset($item['subitems']) && count($item['subitems']) > 0) {
            $filteredSubitems = [];

            foreach ($item['subitems'] as $subitem) {
                $hasSubPermission = true;

                if (isset($subitem['permission']) && !empty($subitem['permission'])) {
                    $hasSubPermission = auth()->user()->can($subitem['permission']);
                }

                if ($hasSubPermission) {
                    $filteredSubitems[] = $subitem;
                }
            }

            // Only include parent if it has accessible subitems
            if (count($filteredSubitems) > 0) {
                // Changed this condition
                $item['subitems'] = $filteredSubitems;
                $filteredItems[] = $item;
            }
        } else {
            // For single items, only include if user has permission
            if ($hasPermission) {
                $filteredItems[] = $item;
            }
        }
    }

    // Use filtered items
    $items = $filteredItems;

    // Check if main item or any sub-item is active
    $isMainActive = $type === 'single' && $page_slug == $active;
    $isDropdownActive = false;

    foreach ($items as $item) {
        if (isset($item['active']) && $page_slug == $item['active']) {
            $isDropdownActive = true;
            break;
        }
        // Check nested items for multi-dropdown
        if (isset($item['subitems'])) {
            foreach ($item['subitems'] as $subitem) {
                if (isset($subitem['active']) && $page_slug == $subitem['active']) {
                    $isDropdownActive = true;
                    break 2;
                }
            }
        }
    }

    $isAnyActive = $isMainActive || $isDropdownActive;
    $shouldShowComponent =
        $type === 'single' ? empty($permission) || auth()->user()->can($permission) : count($items) > 0;

@endphp

@if ($shouldShowComponent)
    <div x-data="{
        open: {{ $isDropdownActive ? 'true' : 'false' }},
        collapsedDropdown: false,
        init() {
            // Auto expand if any dropdown item is active
            if ({{ $isDropdownActive ? 'true' : 'false' }}) {
                this.open = true;
            }
        },
        toggleCollapsedDropdown() {
            if (!desktop || !sidebar_expanded) {
                this.collapsedDropdown = !this.collapsedDropdown;
                // Close other collapsed dropdowns by dispatching event
                $dispatch('close-collapsed-dropdowns', { except: $el });
            }
        },
        closeCollapsedDropdown() {
            this.collapsedDropdown = false;
        }
    }"
        @close-collapsed-dropdowns.window="if ($event.detail.except !== $el) { closeCollapsedDropdown() }"
        @click.away="closeCollapsedDropdown()"> {{-- relative --}}

        @if ($type === 'single')
            <!-- Single Navlink (like original single-navlink) -->
            @if (empty($permission) || auth()->user()->can($permission))
                <a href="{{ $route }}" wire:navigate
                    class="sidebar-item flex items-center gap-4 p-1 rounded-xl hover:bg-hover transition-all duration-200 group {{ $isMainActive ? 'bg-primary hover:bg-primary/80' : '' }}">
                    <div
                        class="w-9 h-9 glass-card shadow-shadow-primary rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform relative {{ $isMainActive ? 'bg-primary border-none ' : '' }}">
                        <flux:icon name="{{ $defaultParentIcon }}"
                            class="w-5 h-5 shrink-0 {{ $isMainActive ? 'stroke-white' : 'stroke-text-base' }}" />
                        <!-- Active indicator for collapsed state -->
                        <div x-show="!((desktop && sidebar_expanded) || (!desktop && mobile_menu_open)) && {{ $isAnyActive ? 'true' : 'false' }}"
                            class="absolute -top-1 -right-1 w-3 h-3 bg-main/50 rounded-full animate-pulse invisible"
                            :class="{
                                'visible': !((desktop && sidebar_expanded) || (!desktop && mobile_menu_open)) &&
                                    {{ $isAnyActive ? 'true' : 'false' }}
                            }">
                        </div>
                    </div>
                    <span x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)"
                        x-transition:enter="transition-all duration-300 delay-75"
                        x-transition:enter-start="opacity-0 translate-x-4"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition-all duration-200"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 -translate-x-4"
                        class="text-sm {{ $isMainActive ? 'text-accent-content font-medium ' : 'text-text-base ' }}">{{ __($name) }}</span>
                    <div x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)"
                        class="ml-auto {{ $isMainActive ? 'block' : 'hidden' }}">
                        <div class="w-2 h-2 bg-main/50 rounded-full animate-pulse"></div>
                    </div>
                </a>
            @endif
        @else
            <!-- Dropdown Button -->
            <button
                @click="((desktop && sidebar_expanded) || (!desktop && mobile_menu_open)) ? (open = !open) : toggleCollapsedDropdown()"
                class="sidebar-item flex items-center gap-4 p-1 rounded-xl hover:bg-hover text-text-primary transition-all duration-200 group w-full {{ $isAnyActive ? 'bg-hover hover:bg-hover/80' : '' }}">
                {{-- relative --}}
                <div
                    class="w-9 h-9 shrink-0 glass-card shadow-shadow-primary rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform relative">
                    <flux:icon name="{{ $defaultParentIcon }}" class="w-5 h-5 shrink-0" />

                    <!-- Active indicator for collapsed state -->
                    <div x-show="!((desktop && sidebar_expanded) || (!desktop && mobile_menu_open)) && {{ $isAnyActive ? 'true' : 'false' }}"
                        class="absolute -top-1 -right-1 w-3 h-3 bg-main/50 rounded-full animate-pulse invisible"
                        :class="{
                            'visible': !((desktop && sidebar_expanded) || (!desktop && mobile_menu_open)) &&
                                {{ $isAnyActive ? 'true' : 'false' }}
                        }">
                    </div>
                </div>

                <span x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)"
                    x-transition:enter="transition-all duration-300 delay-75"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-4"
                    class="text-sm text-left {{ $isAnyActive ? 'font-medium ' : 'text-text-base ' }}">{{ __($name) }}</span>

                <!-- Dropdown Arrow for expanded state -->
                <div x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)"
                    class="ml-auto transition-transform duration-200" :class="open ? 'rotate-180' : ''">
                    <flux:icon name="chevron-down" class="w-3 h-3 stroke-text-base shrink-0" />
                </div>
            </button>
        @endif

        <!-- Collapsed State Dropdown (Floating) - FIXED VERSION -->
        @if ($type === 'dropdown' && count($items) > 0)
            <!-- Portal container for dropdown - positioned fixed to escape sidebar constraints -->
            <div x-show="collapsedDropdown && !((desktop && sidebar_expanded) || (!desktop && mobile_menu_open))"
                x-transition:enter="transition-all duration-300 ease-out"
                x-transition:enter-start="opacity-0 translate-x-2 scale-95"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition-all duration-200 ease-in"
                x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                x-transition:leave-end="opacity-0 translate-x-2 scale-95"
                class="hidden absolute z-9999 min-w-64 max-w-80 bg-card rounded-2xl shadow-shadow-primary border border-border py-3 right-full ml-5 top-0"
                :class="(collapsedDropdown && !((desktop && sidebar_expanded) || (!desktop && mobile_menu_open)) ? 'block!' :
                    'hidden!')"
                style="backdrop-filter: blur(12px);" x-init="// Calculate position relative  to the trigger button
                $nextTick(() => {
                    if (collapsedDropdown) {
                        const triggerRect = $el.previousElementSibling.getBoundingClientRect();
                        const viewportHeight = window.innerHeight;
                        const dropdownHeight = 400; // approximate max height
                
                        // Position to the right of the trigger
                        $el.style.left = (triggerRect.right + 8) + 'px';
                
                        // Position vertically - center with trigger, but ensure it stays in viewport
                        let topPosition = triggerRect.top + (triggerRect.height / 2) - (dropdownHeight / 2);
                
                        // Adjust if dropdown would go off screen
                        if (topPosition < 20) {
                            topPosition = 20;
                        } else if (topPosition + dropdownHeight > viewportHeight - 20) {
                            topPosition = viewportHeight - dropdownHeight - 20;
                        }
                
                        $el.style.top = topPosition + 'px';
                    }
                })"
                x-effect="
                if (collapsedDropdown) {
                    $nextTick(() => {
                        const triggerRect = $el.previousElementSibling.getBoundingClientRect();
                        const viewportHeight = window.innerHeight;
                        const dropdownHeight = 400;

                        $el.style.left = (triggerRect.right + 8) + 'px';

                        let topPosition = triggerRect.top + (triggerRect.height / 2) - (dropdownHeight / 2);

                        if (topPosition < 20) {
                            topPosition = 20;
                        } else if (topPosition + dropdownHeight > viewportHeight - 20) {
                            topPosition = viewportHeight - dropdownHeight - 20;
                        }

                        $el.style.top = topPosition + 'px';
                    });
                }">

                <!-- Header -->
                <div class="px-4 pb-3 border-b border-accent">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 shrink-0 glass-card shadow-shadow-primary rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform relativer">
                            <flux:icon name="{{ $defaultParentIcon }}" class="w-5 h-5 stroke-accent shrink-0" />
                        </div>
                        <div>
                            <h3 class="text-sm">{{ __($name) }}</h3>
                            <p class="text-xs">{{ count($items) }} {{ __('items') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div class="px-2 py-2 max-h-96 overflow-y-auto custom-scrollbar space-y-1">
                    @foreach ($items as $key => $item)
                        @php
                            $subitemIcon = $item['icon'] ?? $defaultSubitemIcon;
                            $subitemBoxicon = $item['boxicon'] ?? false;
                        @endphp

                        @if (isset($item['type']) && $item['type'] === 'single')
                            <!-- Single Navigation Item -->
                            <a href="{{ empty($item['route']) ? 'javascript:void(0);' : $item['route'] }}"
                                wire:navigate
                                class="flex items-center gap-3 p-3 mx-2 glass-card shadow-shadow-primary rounded-lg hover:bg-hover transition-all duration-200 group {{ isset($item['active']) && $page_slug == $item['active'] ? 'bg-primary hover:bg-primary/80 ' : '' }}">
                                <div
                                    class="w-8 h-8 glass-card rounded-lg shadow-shadow-primary flex items-center justify-center group-hover:scale-110 transition-transform relative shrink-0 {{ isset($item['active']) && $page_slug == $item['active'] ? 'bg-primary border-none ' : '' }}">
                                    <flux:icon name="{{ $subitemIcon }}"
                                        class="w-4 h-4 shrink-0 {{ isset($item['active']) && $page_slug == $item['active'] ? 'stroke-white' : 'stroke-text-base' }}" />
                                </div>
                                <div class="flex-1">
                                    <span
                                        class="text-xs {{ isset($item['active']) && $page_slug == $item['active'] ? 'text-white font-medium' : '' }}">{{ __($item['name']) }}</span>
                                </div>
                                @if (isset($item['active']) && $page_slug == $item['active'])
                                    <div class="w-2 h-2 bg-main/50 rounded-full animate-pulse">
                                    </div>
                                @endif
                            </a>
                        @else
                            <!-- Regular dropdown item -->
                            <a href="{{ empty($item['route']) ? 'javascript:void(0);' : $item['route'] }}"
                                wire:navigate
                                class="flex items-center gap-3 p-3 mx-2 rounded-lg hover:bg-hover transition-all duration-200 group {{ isset($item['active']) && $page_slug == $item['active'] ? 'bg-primary hover:bg-primary/80 ' : '' }}">
                                <div
                                    class="w-8 h-8 glass-card rounded-lg shadow-shadow-primary flex items-center justify-center group-hover:scale-110 transition-transform relative shrink-0 {{ isset($item['active']) && $page_slug == $item['active'] ? 'bg-primary border-none ' : '' }}">

                                    <flux:icon name="{{ $subitemIcon }}"
                                        class="w-4 h-4 {{ isset($item['active']) && $page_slug == $item['active'] ? 'stroke-white' : 'stroke-text-base' }}" />

                                </div>
                                <div class="flex-1">
                                    <span
                                        class="text-xs {{ isset($item['active']) && $page_slug == $item['active'] ? 'text-white font-medium ' : '' }}">{{ __($item['name']) }}</span>
                                </div>
                                @if (isset($item['active']) && $page_slug == $item['active'])
                                    <div class="w-2 h-2 bg-main/50 rounded-full animate-pulse">
                                    </div>
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Original Expanded State Dropdown -->
        @if ($type === 'dropdown' && count($items) > 0)
            <div x-show="open && ((desktop && sidebar_expanded) || (!desktop && mobile_menu_open))"
                x-transition:enter="transition-all duration-300 ease-out"
                x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition-all duration-200 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                class="ml-4 mt-2 space-y-1 border-l-2 border-bg-black/10 dark:border-bg-white/10 pl-4 hidden "
                :class="(open && ((desktop && sidebar_expanded) || (!desktop && mobile_menu_open)) ? 'block!' : 'hidden!')">

                @foreach ($items as $item)
                    @php
                        $subitemIcon = $item['icon'] ?? $defaultSubitemIcon;
                        $subitemBoxicon = $item['boxicon'] ?? false;
                    @endphp

                    @if (isset($item['type']) && $item['type'] === 'single')
                        <!-- Single Navigation Item -->
                        <a href="{{ empty($item['route']) ? 'javascript:void(0);' : $item['route'] }}" wire:navigate
                            class="sidebar-item flex items-center gap-4 p-2 rounded-lg hover:bg-hover transition-all duration-200 group {{ isset($item['active']) && $page_slug == $item['active'] ? 'bg-primary hover:bg-primary/80 ' : '' }}">
                            <div
                                class="w-6 h-6 glass-card rounded-lg shadow-shadow-primary flex items-center justify-center group-hover:scale-110 transition-transform relative">
                                <flux:icon name="{{ $subitemIcon }}"
                                    class="w-3 h-3 {{ isset($item['active']) && $page_slug == $item['active'] ? 'stroke-white' : 'stroke-text-base' }}" />
                            </div>
                            <span
                                class="text-xs text-left {{ isset($item['active']) && $page_slug == $item['active'] ? 'text-white font-medium ' : 'text-text-base ' }}">{{ __($item['name']) }}</span>
                        </a>
                    @else
                        <!-- Regular dropdown item -->
                        <a href="{{ empty($item['route']) ? 'javascript:void(0);' : $item['route'] }}" wire:navigate
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-hover transition-all duration-200 group {{ isset($item['active']) && $page_slug == $item['active'] ? 'bg-primary hover:bg-primary/80 ' : '' }}">
                            <div
                                class="w-6 h-6 shrink-0 glass-card rounded-lg shadow-shadow-primary flex items-center justify-center group-hover:scale-110 transition-transform relative {{ isset($item['active']) && $page_slug == $item['active'] ? 'bg-primary border-none ' : '' }}">
                                <flux:icon name="{{ $subitemIcon }}"
                                    class="w-3 h-3 stroke-current {{ isset($item['active']) && $page_slug == $item['active'] ? 'stroke-white' : 'stroke-text-base' }}" />
                            </div>
                            <span
                                class="text-xs {{ isset($item['active']) && $page_slug == $item['active'] ? 'text-white font-medium ' : 'text-text-base ' }}">{{ __($item['name']) }}</span>
                            @if (isset($item['active']) && $page_slug == $item['active'])
                                <div class="ml-auto">
                                    <div class="w-1.5 h-1.5 bg-main/50 rounded-full animate-pulse">
                                    </div>
                                </div>
                            @endif
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endif
