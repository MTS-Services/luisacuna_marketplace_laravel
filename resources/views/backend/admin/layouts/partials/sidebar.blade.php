<aside class="transition-all duration-300 ease-in-out z-20 max-h-screen py-6 pl-6"
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
                <x-sidebar-separator title="Main" :expanded="false" class="p-0!" />

                <x-backend.navlink type="single" icon="layout-dashboard" name="Dashboard" :route="route('admin.dashboard')"
                    active="admin-dashboard" :page_slug="$active" />

                <x-sidebar-separator title="Users & Staff" />

                <x-backend.navlink type="dropdown" icon="shield-user" name="Administrators" :page_slug="$active"
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
                        // [
                        //     'name' => 'Permissions',
                        //     'route' => route('admin.am.permission.index'),
                        //     'icon' => 'shield-check',
                        //     'active' => 'permission',
                        //     'permission' => 'permission-list',
                        // ],
                    ]" />

                <x-backend.navlink type="dropdown" icon="user-group" name="Users" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'All Users',
                            'route' => route('admin.um.user.index'),
                            'icon' => 'users',
                            'active' => 'admin-users',
                            'permission' => 'user-list',
                        ],
                        [
                            'name' => 'Sellers',
                            'route' => route('admin.um.user.all-seller'),
                            'icon' => 'user',
                            'active' => 'sellers',
                            // 'permission' => 'user-list',
                        ],
                        [
                            'name' => 'Buyers',
                            'route' => route('admin.um.user.all-buyer'),
                            'icon' => 'user',
                            'active' => 'buyers',
                            // 'permission' => 'user-list',
                        ],
                        [
                            'name' => 'Pending Verificaiton',
                            'route' => route('admin.um.user.seller-verification'),
                            'icon' => 'user',
                            'active' => 'seller-verification-pending',
                            'permission' => 'user-list',
                        ],
                        [
                            'name' => 'Verified Sellers',
                            'route' => route('admin.um.user.seller-verification.verified'),
                            'icon' => 'user',
                            'active' => 'seller-verification-verified',
                            'permission' => 'user-list',
                        ],
                        [
                            'name' => 'Banned Users',
                            'route' => '#',
                            'icon' => 'user',
                            'active' => 'admin-users-banned',
                            'permission' => 'user-list',
                        ],
                    ]" />

                <x-sidebar-separator title="Catalog" />

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
                            'name' => 'Tags',
                            'route' => route('admin.gm.tag.index'),
                            'icon' => 'joystick',
                            'active' => 'tag',
                            'permission' => 'tag-list',
                        ],
                        [
                            'name' => 'Platforms',
                            'route' => route('admin.gm.platform.index'),
                            'icon' => 'joystick',
                            'active' => 'platform',
                            'permission' => 'platform-list',
                        ],
                    
                        [
                            'name' => 'Games',
                            'route' => route('admin.gm.game.index'),
                            'icon' => 'swords',
                            'active' => 'game',
                            'permission' => 'game-list',
                        ],
                    
                        // [
                        //     'name' => 'Rarity',
                        //     'route' => route('admin.gm.rarity.index'),
                        //     'icon' => 'swords',
                        //     'active' => 'game-rarity',
                        // ],
                    ]" />

                {{-- <x-backend.navlink type="dropdown" icon="box" name="Products" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'Currencies',
                            'route' => route('admin.pm.category.index', 'currency'),
                            'icon' => 'currency-dollar',
                            'active' => 'currency',
                        ],
                        [
                            'name' => 'Accounts',
                            'route' => route('admin.pm.category.index', 'accounts'),
                            'icon' => 'chess-pawn',
                            'active' => 'account',
                        ],
                        [
                            'name' => 'Top Ups',
                            'route' => route('admin.pm.top-ups.index'),
                            'icon' => 'bitcoin',
                            'active' => 'top-ups',
                        ],
                        [
                            'name' => 'Items',
                            'route' => route('admin.pm.items.index'),
                            'icon' => 'bow-arrow',
                            'active' => 'items',
                        ],
                        [
                            'name' => 'Boostings',
                            'route' => route('admin.pm.boostings.index'),
                            'icon' => 'rocket',
                            'active' => 'boostings',
                        ],
                        [
                            'name' => 'Gift Cards',
                            'route' => route('admin.pm.category.index', 'gift-card'),
                            'icon' => 'gift',
                            'active' => 'gift-cards',
                        ],
                    ]" /> --}}
                @php
                    $productItems = [];

                    foreach ($categories as $cat) {
                        $productItems[] = [
                            'name' => $cat->name,
                            'route' => route('admin.pm.category.index', $cat->slug),
                            // 'icon' => $cat->icon ?? 'circle',
                            'active' => $cat->slug,
                        ];
                    }
                @endphp


                {{-- Dropdown Component --}}
                <x-backend.navlink type="dropdown" icon="box" name="Products" :page_slug="$active"
                    :items="$productItems" />

                <x-backend.navlink type="dropdown" icon="layers" name="Order Management" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'All Orders',
                            'route' => route('admin.orders.index'),
                            'icon' => 'trophy',
                            'active' => 'order-management',
                            'permission' => 'rank-list',
                        ],
                        [
                            'name' => 'Progress Orders',
                            'route' => route('admin.orders.progress-orders'),
                            'icon' => 'award',
                            'active' => 'progress-orders',
                            'permission' => 'achievement-type-list',
                        ],
                        [
                            'name' => 'Complete Orders',
                            'route' => route('admin.orders.completed-orders'),
                            'icon' => 'medal',
                            'active' => 'completed-orders',
                            'permission' => 'achievement-list',
                        ],
                        [
                            'name' => 'Cancelled Orders',
                            'route' => route('admin.orders.cancelled-orders'),
                            'icon' => 'medal',
                            'active' => 'cancelled-orders',
                            'permission' => 'achievement-list',
                        ],
                        [
                            'name' => 'Disputed Orders',
                            'route' => route('admin.orders.dispute-orders'),
                            'icon' => 'medal',
                            'active' => 'dispute-orders',
                            'permission' => 'achievement-list',
                        ],
                    ]" />

                <x-backend.navlink type="dropdown" icon="layers" name="Level Management" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'Ranks',
                            'route' => route('admin.rm.rank.index'),
                            'icon' => 'trophy',
                            'active' => 'rank',
                            'permission' => 'rank-list',
                        ],
                        [
                            'name' => 'Achievement Types',
                            'route' => route('admin.rm.achievementType.index'),
                            'icon' => 'award',
                            'active' => 'achievement-type',
                            // 'permission' => 'achievement-type-list',
                        ],
                        [
                            'name' => 'Achievements',
                            'route' => route('admin.rm.achievement.index'),
                            'icon' => 'medal',
                            'active' => 'achievement',
                            'permission' => 'achievement-list',
                        ],
                    ]" />

                <x-sidebar-separator title="Finance" />
                <x-backend.navlink type="dropdown" icon="currency-dollar" name="Finance Management" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'All Transactions',
                            'route' => route('admin.finance.index'),
                            'icon' => 'badge-dollar-sign',
                            'active' => 'finance-management',
                        ],
                        [
                            'name' => 'Top Ups',
                            'route' => route('admin.finance.top-ups'),
                            'icon' => 'dollar-sign',
                            'active' => 'top-ups',
                        ],
                        [
                            'name' => 'purchased',
                            'route' => route('admin.finance.purchased'),
                            'icon' => 'dollar-sign',
                            'active' => 'purchased',
                        ],
                        [
                            'name' => 'Withdrawals',
                            'route' => route('admin.finance.withdrawals'),
                            'icon' => 'dollar-sign',
                            'active' => 'withdrawals',
                        ],
                    ]" />
                <x-backend.navlink type="single" icon="percent" name="Fee Settings" :route="route('admin.fee-settings.fee-settings')"
                    active="fee-settings" :page_slug="$active" />

                <x-sidebar-separator title="Support" />
                <x-backend.navlink type="single" icon="megaphone" name="Announcements" :route="route('admin.announcement.index')"
                    active="announcement" :page_slug="$active" />
                <x-backend.navlink type="single" icon="messages-square" name="Chat List" :route="route('admin.conversation.index')"
                    active="admin-conversations" :page_slug="$active" />
                <x-backend.navlink type="dropdown" icon="headset" name="Supports" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'Tickets',
                            'route' => '#',
                            'icon' => 'ticket',
                            'active' => 'ticket',
                        ],
                        [
                            'name' => 'Reviews',
                            'route' => '#',
                            'icon' => 'star',
                            'active' => 'star',
                        ],
                    ]" />
                <x-sidebar-separator title="Content" />
                <x-backend.navlink type="dropdown" icon="headset" name="Content Management" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'Banner',
                            'route' => route('admin.bm.banner.index'),
                            'icon' => 'megaphone',
                            'active' => 'banner-management',
                        ],
                        [
                            'name' => 'Faqs',
                            'route' => route('admin.flm.faq.index'),
                            'icon' => 'question-mark-circle',
                            'active' => 'faq-management',
                        ],
                        [
                            'name' => 'Terms & Conditions',
                            'route' => route('admin.cms.terms-condition'),
                            'icon' => 'notebook-text',
                            'active' => 'terms_condition',
                        ],
                        [
                            'name' => 'Privacy Policy',
                            'route' => route('admin.cms.privacy-policy'),
                            'icon' => 'notepad-text',
                            'active' => 'privacy_policy',
                        ],
                        [
                            'name' => 'Refunds Policy',
                            'route' => route('admin.cms.refund-policy'),
                            'icon' => 'notepad-text-dashed',
                            'active' => 'refund_policy',
                        ],
                    ]" />
                <x-sidebar-separator title="System" />
                <x-backend.navlink type="dropdown" icon="squares-exclude" name="Withdrawal Management"
                    :page_slug="$active" :items="[
                        [
                            'name' => 'Withdrawal Methods',
                            'route' => route('admin.wm.method.index'),
                            'icon' => 'wallet-minimal',
                            'active' => 'withdrawal-method',
                        ],
                    ]" />
                <x-backend.navlink type="dropdown" icon="squares-exclude" name="Gateway's & Integration"
                    :page_slug="$active" :items="[
                        [
                            'name' => 'Payment Gateway\'s',
                            'route' => route('admin.gi.pay-g.index'),
                            'icon' => 'wallet-minimal',
                            'active' => 'payment-gateway',
                        ],
                        [
                            'name' => 'Withdrawal Gateway\'s',
                            'route' => '#',
                            'icon' => 'credit-card',
                            'active' => 'payout-gateway',
                        ],
                        [
                            'name' => 'Translation Keys',
                            'route' => '#',
                            'icon' => 'languages',
                            'active' => 'translation-key',
                        ],
                    ]" />
                <x-backend.navlink type="dropdown" icon="radiation" name="Track Management" :page_slug="$active"
                    :items="[
                        [
                            'name' => 'Audit Logs',
                            'route' => route('admin.alm.audit.index'),
                            'icon' => 'pen-line',
                            'active' => 'audit-log-management',
                        ],
                        [
                            'name' => 'Page View',
                            'route' => route('admin.rm.review.index'),
                            'icon' => 'telescope',
                            'active' => 'rewiew-management',
                        ],
                    ]" />
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
                    <x-backend.navlink type="single" icon="user" name="Profile " active="profile" :route="route('admin.profile.index')"
                        :page_slug="$active" />

                    <form action="{{ route('admin.logout') }}" method="post" class="w-full inline-block">
                        @csrf
                        <x-backend.navlink type="single" icon="power" name="Logout" :isSubmission="true" />
                    </form>
                </div>
            </nav>
        </div>
    </div>
</aside>
