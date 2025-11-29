<aside class="transition-all duration-300 ease-in-out z-50 max-h-screen py-6 pl-6"
    :class="{
        'w-64': desktop && sidebar_expanded,
        'w-24': desktop && !sidebar_expanded,
        'fixed top-0 left-0 h-full': !desktop,
        'w-64 translate-x-0': !desktop && mobile_menu_open,
        'w-64 -translate-x-full': !desktop && !mobile_menu_open,
    }">

    <div class="glass-card h-full rounded-2xl flex flex-col">
        <a href="{{ route('admin.dashboard') }}" wire:navigate class="p-3 inline-block">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10  shadow-shadow-primary p-0 rounded-xl flex items-center justify-center glass-card">
                    <flux:icon name="shield" class="w-5 h-5 text-zinc-500" />
                </div>
                <div x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)"
                    x-transition:enter="transition-all duration-300 delay-75"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-4">
                    <h1 class="font-bold text-text-primary text-sm">{{ __('Admin Panel') }}</h1>
                </div>
            </div>
        </a>
        <flux:separator class="bg-accent!" />
        <div class="flex-1 overflow-y-auto custom-scrollbar">
            <nav class="p-2 space-y-2">
                <x-sidebar-separator title="Main" :expanded="false" />

                <x-backend.navlink type="single" icon="layout-dashboard" name="Dashboard" :route="route('admin.dashboard')"
                    active="admin-dashboard" :page_slug="$active" />
                <x-backend.navlink type="single" icon="layout-dashboard" name="Dashboard" :route="route('admin.dashboard')"
                    active="admin-dashboards" :page_slug="$active" />

                <x-sidebar-separator title="Management" />
                <x-backend.navlink type="dropdown" icon="users" name="Admin Management" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'Admins',
                            'route' => route('admin.am.admin.index'),
                            'icon' => 'user-circle',
                            'active' => 'admin',
                            'permission' => 'admin-list',
                        ],
                        [
                            'name' => 'Roles',
                            'route' => route('admin.am.role.index'),
                            'icon' => 'shield-exclamation',
                            'active' => 'role',
                            'permission' => 'role-list',
                        ],
                        [
                            'name' => 'Permissions',
                            'route' => route('admin.am.permission.index'),
                            'icon' => 'shield-check',
                            'active' => 'permission',
                            'permission' => 'permission-list',
                        ],
                    ]" />

                <x-backend.navlink type="dropdown" icon="user-group" name="User Management" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'All Users',
                            'route' => route('admin.um.user.index'),
                            'icon' => 'user',
                            'active' => 'admin-users',
                            'permission' => 'user-list',
                        ],
                        [
                            'name' => 'All Sellers',
                            'route' => route('admin.um.user.all-seller'),
                            'icon' => 'user',
                            'active' => 'sellers',
                            // 'permission' => 'user-list',
                        ],
                        [
                            'name' => 'All Buyers',
                            'route' => route('admin.um.user.all-buyer'),
                            'icon' => 'user',
                            'active' => 'buyers',
                            // 'permission' => 'user-list',
                        ],
                        // [
                        //     'name' => 'Pending Users',
                        //     'route' => '#',
                        //     'icon' => 'user-plus',
                        //     'active' => 'admin-users-pending',
                        // ],
                        // [
                        //     'name' => 'Banned Users',
                        //     'route' => '#',
                        //     'icon' => 'user-round-x',
                        //     'active' => 'admin-users-banned',
                        // ],
                    ]" />

                <x-backend.navlink type="dropdown" icon="gamepad-directional" name="Game Management" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'Categories',
                            'route' => route('admin.gm.category.index'),
                            'icon' => 'gamepad-2',
                            'active' => 'game-category',
                            'permission' => 'category-list',
                        ],
                    
                        // [
                        //     'name' => 'Servers',
                        //     'route' => route('admin.gm.server.index'),
                        //     'icon' => 'swords',
                        //     'active' => 'server',
                        //     'permission' => 'server-list',
                        // ],
                    
                        [
                            'name' => 'Platforms',
                            'route' => route('admin.gm.platform.index'),
                            'icon' => 'swords',
                            'active' => 'game-platform',
                            'permission' => 'platform-list',
                        ],
                    
                        [
                            'name' => 'Games',
                            'route' => route('admin.gm.game.index'),
                            'icon' => 'swords',
                            'active' => 'game',
                            'permission' => 'game-list',
                        ],
                    
                        [
                            'name' => 'Rarity',
                            'route' => route('admin.gm.rarity.index'),
                            'icon' => 'swords',
                            'active' => 'game-rarity',
                        ],
                    
                        // [
                        //     'name' => 'Pending Users',
                        //     'route' => '#',
                        //     'icon' => 'user-plus',
                        //     'active' => 'admin-users-pending',
                        // ],
                    
                        // [
                        //     'name' => 'Banned Users',
                        //     'route' => '#',
                        //     'icon' => 'user-round-x',
                        //     'active' => 'admin-users-banned',
                        // ],
                    ]" />

                <x-backend.navlink type="dropdown" icon="user-group" name="Product Management" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'Product Types',
                            'route' => '#',
                            'icon' => 'user',
                            'active' => 'product-type',
                        ],
                        [
                            'name' => 'Products',
                            'route' => '#',
                            'icon' => 'user',
                            'active' => 'product',
                        ],
                    ]" />
                <x-backend.navlink type="dropdown" icon="gift" name="Offer Item Management" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'Offer Items',
                            'route' => route('admin.om.offer.index'),
                            'icon' => 'gift',
                            'active' => 'offer-item',
                        ],
                    ]" />

                <x-backend.navlink type="dropdown" icon="user-group" name="Reward Management" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'Ranks',
                            'route' => route('admin.rm.rank.index'),
                            'icon' => 'user',
                            'active' => 'rank',
                            'permission' => 'rank-list',
                        ],
                        [
                            'name' => 'Achievement Types',
                            'route' => route('admin.rm.achievementType.index'),
                            'icon' => 'user',
                            'active' => 'achievement-type',
                            'permission' => 'achievement-type-list',
                        ],
                        [
                            'name' => 'Achievements',
                            'route' => route('admin.rm.achievement.index'),
                            'icon' => 'user',
                            'active' => 'achievement',
                            'permission' => 'achievement-list',
                        ],
                        // [
                        //     'name' => 'Pending Users',
                        //     'route' => '#',
                        //     'icon' => 'user-plus',
                        //     'active' => 'admin-users-pending',
                        // ],
                        // [
                        //     'name' => 'Banned Users',
                        //     'route' => '#',
                        //     'icon' => 'user-round-x',
                        //     'active' => 'admin-users-banned',
                        // ],
                    ]" />

                <x-backend.navlink type="dropdown" icon="user-group" name="Review Management" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'Page View',
                            'route' => route('admin.rm.review.index'),
                            'icon' => 'user',
                            'active' => 'rewiew-management',
                        ],
                        // [
                        //     'name' => 'Products',
                        //     'route' => route('admin.pm.product.index'),
                        //     'icon' => 'user',
                        //     'active' => 'product',
                        // ],
                        // [
                        //     'name' => 'Pending Users',
                        //     'route' => '#',
                        //     'icon' => 'user-plus',
                        //     'active' => 'admin-users-pending',
                        // ],
                        // [
                        //     'name' => 'Banned Users',
                        //     'route' => '#',
                        //     'icon' => 'user-round-x',
                        //     'active' => 'admin-users-banned',
                        // ],
                    ]" />

                <x-backend.navlink type="dropdown" icon="user-group" name="Audit Log Management" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'Audit Logs',
                            'route' => route('admin.alm.audit.index'),
                            'icon' => 'user',
                            'active' => 'audit-log-management',
                        ],
                    ]" />

                <div class="pt-4 pb-2">
                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase"
                        x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)">
                        {{ __('Settings & Tools') }}</p>
                    <p class="text-center text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase"
                        x-show="desktop && !sidebar_expanded">...</p>
                </div>
                <x-backend.navlink type="dropdown" icon="wrench-screwdriver" name="Application Settings"
                    :page_slug="$active" :items="[
                        [
                            'name' => 'General Settings',
                            'route' => route('admin.as.general-settings'),
                            'icon' => 'cog-8-tooth',
                            'active' => 'general-settings',
                        ],
                        // [
                        //     'name' => 'Appearance',
                        //     'route' => '#',
                        //     'icon' => 'palette',
                        //     'active' => 'settings-appearance',
                        // ],
                        [
                            'name' => 'Security',
                            'route' => route('admin.two-factor.index'),
                            'icon' => 'shield',
                            'active' => 'two-factor',
                        ],
                        [
                            'name' => 'Languages',
                            'route' => route('admin.as.language.index'),
                            'icon' => 'language',
                            'active' => 'language',
                        ],
                        [
                            'name' => 'Currencies',
                            'route' => route('admin.as.currency.index'),
                            'icon' => 'currency-dollar',
                            'active' => 'currency',
                        ],
                        // [
                        //     'name' => 'Analytics',
                        //     'route' => '#',
                        //     'icon' => 'chart-bar',
                        //     'active' => 'settings-analytics',
                        // ],
                        // [
                        //     'name' => 'Support',
                        //     'route' => '#',
                        //     'icon' => 'headset',
                        //     'active' => 'settings-support',
                        // ],
                        // [
                        //     'name' => 'Notifications',
                        //     'route' => '#',
                        //     'icon' => 'bell',
                        //     'active' => 'settings-notifications',
                        // ],
                        // [
                        //     'name' => 'Database',
                        //     'route' => route('admin.app-settings.database'),
                        //     'icon' => 'database',
                        //     'active' => 'settings-database',
                        // ],
                        // [
                        //     'name' => 'SMTP',
                        //     'route' => route('admin.app-settings.smtp'),
                        //     'icon' => 'envelope',
                        //     'active' => 'app-smtp-settings',
                        // ],
                    ]" />

                <div class="space-y-2">
                    <flux:separator class="bg-accent!" />
                    <x-backend.navlink type="single" icon="user" name="Profile" active="profile"
                        :page_slug="$active" />
                    <button wire:click="logout" class="w-full text-left">
                        <x-backend.navlink type="single" icon="power" name="Logout" />
                    </button>
                </div>
            </nav>
        </div>
    </div>
</aside>
