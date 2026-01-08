<div>
    <div class="max-w-7xl mx-auto space-y-8">
        <div class="glass-card rounded-2xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Admin Profile') }}</h2>
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-2">
                        <x-ui.button href="{{ route('admin.profile.edit', encrypt($admin->id)) }}" class="w-auto! py-2!">
                            {{ __('Edit') }}
                            <flux:icon name="pencil" class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <div class="lg:col-span-4">
                <div
                    class="sticky top-8 glass-card rounded-3xl p-8 shadow-sm border border-zinc-200/50 dark:border-zinc-700/30 backdrop-blur-md">
                    <div class="flex flex-col items-center text-center">
                        <div class="relative group">
                            <div
                                class="relative w-40 h-40 rounded-full overflow-hidden border-4 border-zinc-200 dark:border-zinc-800 shadow-xl">
                                <img src="{{ auth_storage_url(admin()->avatar) }}" alt="{{ admin()->name }}"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                            </div>
                        </div>

                        <div class="mt-8 space-y-2">
                            <h3 class="text-2xl font-bold text-text-white leading-tight">
                                {{ $admin?->name }}</h3>
                            <div class="flex flex-wrap justify-center gap-2 mt-2">
                                <span
                                    class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400 border border-primary-200/50 dark:border-primary-500/20">
                                    {{ $admin?->role->name }}
                                </span>
                                <span
                                    class="text-text-white font-medium badge badge-soft {{ $admin->status->color() }}">{{ $admin?->status?->label() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 space-y-8">
                <div
                    class="glass-card rounded-3xl shadow-sm border border-zinc-200/50 dark:border-zinc-700/30 overflow-hidden">
                    <div class="px-8 py-6 border-b border-zinc-100 dark:border-zinc-800 bg-main">
                        <h3 class="text-xl font-bold text-text-white">{{ __('Profile Information') }}
                        </h3>
                    </div>

                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">

                        <div class="space-y-8">
                            <h4
                                class="flex items-center gap-2 text-[11px] font-black text-text-white uppercase tracking-[0.2em]">
                                <span class="w-8 h-px bg-zinc-200 dark:bg-zinc-700"></span>
                                {{ __('General Details') }}
                            </h4>

                            <div class="flex items-start gap-4">
                                <div class="mt-1 p-2.5 rounded-xl bg-main text-text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-text-white uppercase tracking-wider">
                                        {{ __('Name') }}</p>
                                    <p class="text-lg font-semibold text-text-white">{{ $admin?->name }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="mt-1 p-2.5 rounded-xl bg-main text-text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-bold text-text-white uppercase tracking-wider">
                                        {{ __('Email Address') }}</p>
                                    <p class="text-lg font-semibold text-text-white truncate">{{ $admin?->email }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="mt-1 p-2.5 rounded-xl bg-main text-text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-text-white uppercase tracking-wider">
                                        {{ __('Phone Number') }}</p>
                                    <p class="text-lg font-semibold text-text-white">{{ $admin?->phone }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-8">
                            <h4
                                class="flex items-center gap-2 text-[11px] font-black text-text-white uppercase tracking-[0.2em]">
                                <span class="w-8 h-px bg-zinc-200 dark:bg-zinc-700"></span>
                                {{ __('System Meta') }}
                            </h4>

                            <div class="grid grid-cols-1 gap-6">
                                <div
                                    class="flex justify-between items-center p-4 rounded-2xl bg-main border border-zinc-100 dark:border-zinc-800">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-width="2"
                                                d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2v-5H3v5a2 2 0 002 2z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium text-text-white">{{ __('Member Since At') }}</span>
                                    </div>
                                    <span
                                        class="text-sm font-bold text-text-white">{{ $admin?->created_at_formatted }}</span>
                                </div>

                                <div
                                    class="flex justify-between items-center p-4 rounded-2xl bg-main border border-zinc-100 dark:border-zinc-800">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-sm font-medium text-text-white">{{ __('Last Login') }}</span>
                                    </div>
                                    <span
                                        class="text-sm font-bold text-text-white">{{ $admin?->last_login_formatted }}</span>
                                </div>

                                <div
                                    class="flex justify-between items-center p-4 rounded-2xl bg-main border border-zinc-100 dark:border-zinc-800">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-width="2"
                                                d="M9 12l2 2l4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium text-text-white">{{ __('Last Login IP') }}</span>
                                    </div>
                                    <span
                                        class="text-xs font-bold px-2 py-1 rounded text-text-white">{{ $admin?->last_login_ip }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-8 py-6 bg-main border-t border-zinc-100 dark:border-zinc-800 flex flex-wrap gap-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-zinc-500 animate-pulse"></span>
                            <span
                                class="text-xs font-bold text-text-white uppercase tracking-tighter">{{ __('Email Verified') }}:
                                <span
                                    class="text-text-white ml-1">{{ $admin?->email_verified_at ? __('Yes') : __('No') }}</span></span>
                        </div>
                        <div class="w-px h-4 bg-zinc-300 dark:bg-zinc-700"></div>
                        <div class="flex items-center gap-2">
                            <span
                                class="text-xs font-bold text-text-white uppercase tracking-tighter">{{ __('Phone Verified') }}:
                                <span
                                    class="text-primary-600 dark:text-primary-400 ml-1">{{ $admin?->phone_verified_at ? __('Yes') : __('No') }}</span></span>
                        </div>
                        <div class="w-px h-4 bg-zinc-300 dark:bg-zinc-700"></div>
                        <div class="flex items-center gap-2">
                            <span
                                class="text-xs font-bold text-text-white uppercase tracking-tighter">{{ __('2FA') }}:
                                <span
                                    class="text-text-white">{{ $admin?->tow_factor_confirmed_at ? __('Yes') : __('No') }}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
