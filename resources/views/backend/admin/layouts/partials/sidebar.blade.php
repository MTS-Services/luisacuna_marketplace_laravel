<aside class="transition-all duration-300 ease-in-out z-50 max-h-screen py-2 pl-2"
    :class="{
        'w-72': desktop && sidebar_expanded,
        'w-20': desktop && !sidebar_expanded,
        'fixed top-0 left-0 h-full': !desktop,
        'w-72 translate-x-0': !desktop && mobile_menu_open,
        'w-72 -translate-x-full': !desktop && !mobile_menu_open,
    }">

    <div class="sidebar-glass-card h-full rounded-xl overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" wire:navigate class="p-4 inline-block">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10  shadow inset-shadow-lg p-0 rounded-xl flex items-center justify-center">
                    <flux:icon name="bolt" class="w-5 h-5 text-zinc-500" />
                </div>
                <div x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)"
                    x-transition:enter="transition-all duration-300 delay-75"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-4">
                    <h1 class="text-xl font-bold text-accent-content">{{ short_name() }}</h1>
                    <p class="text-text-secondary text-sm">{{ site_tagline() }}</p>
                </div>
            </div>
        </a>

        <flux:separator class="bg-accent!" />

        <nav class="p-2 space-y-2">
            <x-backend.navlink type="single" icon="layout-dashboard" name="Dashboard" :route="route('admin.dashboard')"
                active="admin-dashboard" :page_slug="$active" />
            {{-- <x-backend.navlink type="single" icon="chart-pie" name="Analytics" active="analytics" :page_slug="$active" />
            <x-backend.navlink type="single" icon="inbox" name="Inbox" active="inbox" :page_slug="$active" /> --}}

            <div class="pt-4 pb-2">
                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase"
                    x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)">{{ __('Management') }}</p>
                <p class="text-center text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase"
                    x-show="desktop && !sidebar_expanded">...</p>
            </div>
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
                        'active' => 'admin-users',
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
                    [
                        'name' => 'Games',
                        'route' => route('admin.gm.game.index'),
                        'icon' => 'swords',
                        'active' => 'game',
                        'permission' => 'game-list',
                    ],
                ]" />

            <x-backend.navlink type="dropdown" icon="user-group" name="Product Management" :page_slug="$active"
                :items="[
                    // [
                    //     'name' => 'Product Types',
                    //     'route' => '#',
                    //     'icon' => 'user',
                    //     'active' => 'product-type',
                    // ],
                    // [
                    //     'name' => 'Products',
                    //     'route' => '#',
                    //     'icon' => 'user',
                    //     'active' => 'product',
                    // ],
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
                ]" />

            <x-backend.navlink type="dropdown" icon="user-group" name="Review Management" :page_slug="$active"
                :items="[
                    [
                        'name' => 'Page View',
                        'route' => route('admin.rm.review.index'),
                        'icon' => 'user',
                        'active' => 'rewiew-management',
                    ],
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
            <x-backend.navlink type="dropdown" icon="wrench-screwdriver" name="Application Settings" :page_slug="$active"
                :items="[
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
                <x-backend.navlink type="single" icon="user" name="Profile" active="profile" :page_slug="$active" />
                <button wire:click="logout" class="w-full text-left">
                    <x-backend.navlink type="single" icon="power" name="Logout" />
                </button>
            </div>
        </nav>
    </div>
</aside>
