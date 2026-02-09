<div>
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                {{ __('User Profile') }}
            </h2>

            <div class="flex items-center gap-2">
                    <x-ui.button
                            x-on:click="$dispatch('show-translation-modal', {
                                modelId: '{{ encrypt($user->id) }}',
                                modelType: '{{ base64_encode(\App\Models\User::class) }}'
                            })"
                            variant="secondary" class="w-auto py-2! text-nowrap">
                            <flux:icon name="arrows-pointing-out"
                                class="w-4 h-4 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                            {{ __('Manage Translations') }}
                        </x-ui.button>
                <x-ui.button href="{{ route('admin.um.user.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="max-w-[1600px] mx-auto p-4 lg:p-8 space-y-8 animate-in fade-in duration-700">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Left Sidebar: Identity Card --}}
            <div class="lg:col-span-3 space-y-6">
                <div
                    class="glass-card rounded-[2.5rem] p-8 border border-zinc-200 dark:border-white/10 bg-white/50 dark:bg-zinc-900/30 shadow-2xl relative overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-primary-500/10 rounded-full blur-3xl"></div>

                    <div class="relative flex flex-col items-center">
                        <div class="relative group">
                            <div
                                class="w-40 h-40 rounded-[3rem] rotate-3 group-hover:rotate-0 transition-all duration-500 overflow-hidden border-4 border-white dark:border-zinc-800 shadow-2xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                @if ($user->avatar)
                                    <img src="{{ auth_storage_url($user->avatar) }}"
                                        class="w-full h-full object-cover -rotate-3 group-hover:rotate-0 scale-110 transition-all duration-500"
                                        alt="{{ $user->full_name }}">
                                @else
                                    <div
                                        class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-500 to-indigo-600">
                                        <span
                                            class="text-4xl font-black text-white">{{ strtoupper(substr($user->username, 0, 2)) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-8 text-center space-y-1">
                            <h3 class="text-2xl font-black text-text-primary tracking-tight">
                                {{ $user->first_name }} {{ $user->last_name }}</h3>
                            <p class="text-primary-600 dark:text-primary-400 font-bold text-sm">@ {{ $user->username }}
                            </p>
                            <p class="text-text-primary text-xs text-center font-medium">
                                {{ $user->email }}</p>
                        </div>

                        <div class="w-full grid grid-cols-2 gap-3 mt-8">
                            <div
                                class="p-3 rounded-2xl bg-zinc-100/80 dark:bg-white/5 border border-zinc-200 dark:border-white/5 text-center hover:shadow-inner transition-all">
                                <p
                                    class="text-[10px] text-text-primary uppercase font-black tracking-tighter">
                                    {{ __('Points') }}</p>
                                <p class="text-lg font-black text-primary-600 dark:text-primary-400">
                                    {{ $user->userPoint->points ?? 0 }}</p>
                            </div>
                            <div
                                class="p-3 rounded-2xl bg-zinc-100/80 dark:bg-white/5 border border-zinc-200 dark:border-white/5 text-center hover:shadow-inner transition-all">
                                <p
                                    class="text-[10px] text-text-primary uppercase font-black tracking-tighter">
                                    {{ __('Rank') }}</p>
                                <p class="text-xs font-black text-text-primary truncate">
                                    {{ $user->userRank->rank->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Social Connections & Points Note --}}
                <div
                    class="glass-card rounded-[2rem] p-6 space-y-4 border border-zinc-200 dark:border-white/5 bg-zinc-50 dark:bg-zinc-900/20 shadow-sm">
                    <h4 class="text-[10px] font-black text-text-primary uppercase tracking-[0.2em] px-2">
                        {{ __('Verification & Social') }}</h4>
                    <div class="space-y-2">
                        @foreach (['Google' => $user->google_id, 'Facebook' => $user->facebook_id, 'Apple' => $user->apple_id] as $label => $val)
                            <div
                                class="flex items-center justify-between p-3 rounded-xl bg-white dark:bg-white/5 border border-zinc-100 dark:border-white/5 shadow-sm">
                                <span class="text-xs font-bold text-text-primary">{{ $label }}
                                    ID</span>
                                <span
                                    class="text-[11px] font-mono font-bold text-text-primary">{{ $val ?? 'N/A' }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div
                        class="p-4 rounded-xl bg-primary-50 dark:bg-primary-500/5 border border-primary-100 dark:border-primary-500/10 mt-4">
                        <p class="text-[10px] font-black text-primary-600 dark:text-primary-500 uppercase mb-1">
                            {{ __('Point Note') }}</p>
                        <p class="text-xs text-zinc-600 dark:text-zinc-300 leading-relaxed italic opacity-90">
                            "{{ $user->userPoint->note ?? 'No points notes available.' }}"</p>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-9 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Identity Box --}}
                    <div
                        class="md:col-span-2 glass-card rounded-[2.5rem] overflow-hidden border border-zinc-200 dark:border-white/10 shadow-xl bg-white dark:bg-zinc-900/30">
                        <div class="bg-zinc-50 dark:bg-white/5 p-6 border-b border-zinc-100 dark:border-white/5">
                            <h3
                                class="font-black text-text-primary uppercase tracking-widest text-sm flex items-center gap-2">
                                <flux:icon name="user" class="w-4 h-4 text-primary-500" />
                                {{ __('Identity & Localization') }}
                            </h3>
                        </div>
                        <div class="p-8 grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-8">
                            @php
                                $fields = [
                                    [
                                        'label' => 'Full Name',
                                        'val' => $user->first_name . ' ' . $user->last_name,
                                        'icon' => 'identification',
                                    ],
                                    [
                                        'label' => 'Date of Birth',
                                        'val' => $user->date_of_birth ?? 'N/A',
                                        'icon' => 'calendar',
                                    ],
                                    [
                                        'label' => 'Country',
                                        'val' => $user->country->name ?? 'N/A',
                                        'icon' => 'globe-alt',
                                    ],
                                    [
                                        'label' => 'Language',
                                        'val' => $user->language->name ?? 'N/A',
                                        'icon' => 'language',
                                    ],
                                    [
                                        'label' => 'Currency',
                                        'val' => $user->currency->name ?? 'N/A',
                                        'icon' => 'banknotes',
                                    ],
                                    ['label' => 'Timezone', 'val' => $user->timezone ?? 'N/A', 'icon' => 'clock'],
                                ];
                            @endphp

                            @foreach ($fields as $f)
                                <div class="flex items-start gap-4">
                                    <div
                                        class="p-2.5 rounded-xl bg-zinc-100 dark:bg-white/5 text-text-primary">
                                        <flux:icon :name="$f['icon']" class="w-4 h-4" />
                                    </div>
                                    <div>
                                        <p
                                            class="text-[10px] font-black text-text-primary uppercase">
                                            {{ __($f['label']) }}</p>
                                        <p class="text-sm font-bold text-text-primary">
                                            {{ $f['val'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Status Box --}}
                    <div
                        class="glass-card rounded-[2.5rem] p-8 border border-zinc-200 dark:border-white/10 shadow-xl bg-white dark:bg-zinc-900/30">
                        <h3 class="font-black text-text-primary uppercase tracking-widest text-sm mb-6">
                            {{ __('Account Control') }}</h3>
                        <div class="space-y-5">
                            <div
                                class="p-4 rounded-2xl bg-zinc-50 dark:bg-zinc-900/60 border border-zinc-100 dark:border-white/5 shadow-sm">
                                <p class="text-[10px] font-black text-text-primary uppercase mb-2">
                                    {{ __('Account Status') }}</p>
                                <span
                                    class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase {{ $user->account_status->color() }} bg-opacity-10 dark:bg-opacity-20 border border-current shadow-sm">
                                    {{ $user->account_status->label() }}
                                </span>
                            </div>
                            <div
                                class="p-4 rounded-2xl bg-zinc-50 dark:bg-zinc-900/60 border border-zinc-100 dark:border-white/5 shadow-sm">
                                <p class="text-[10px] font-black text-text-primary uppercase mb-2">
                                    {{ __('Rank Status') }}</p>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="h-2 w-2 rounded-full {{ $user->userRank && $user->userRank->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                                    <span
                                        class="text-sm font-bold text-text-primary">{{ $user->userRank && $user->userRank->is_active ? 'Active Rank' : 'Inactive' }}</span>
                                </div>
                            </div>
                            <div
                                class="flex items-center justify-between px-2 pt-2 border-t border-zinc-100 dark:border-white/5">
                                <span class="text-[10px] font-black text-text-primary uppercase">2FA
                                    Auth</span>
                                <span
                                    class="text-xs font-black {{ $user->two_factor_enabled ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                    {{ $user->two_factor_enabled ? 'ENABLED' : 'DISABLED' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Audit Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @php
                        $audits = [
                            [
                                'label' => 'Created',
                                'color' => 'text-primary-600',
                                'bg' => 'bg-primary-50',
                                'user' => getAuditorName($user->creater),
                                'date' => $user->created_at_formatted,
                            ],
                            [
                                'label' => 'Updated',
                                'color' => 'text-blue-600',
                                'bg' => 'bg-blue-50',
                                'user' => getAuditorName($user->updater) ?? 'System',
                                'date' => $user->updated_at_formatted,
                            ],
                            [
                                'label' => 'Deleted',
                                'color' => 'text-rose-600',
                                'bg' => 'bg-rose-50',
                                'user' => $user->deleted_at ? getAuditorName($user->deleter) : 'N/A',
                                'date' => $user->deleted_at_formatted ?? 'Active',
                            ],
                            [
                                'label' => 'Restored',
                                'color' => 'text-emerald-600',
                                'bg' => 'bg-emerald-50',
                                'user' => $user->restored_at ? getAuditorName($user->restorer) : 'N/A',
                                'date' => $user->restored_at_formatted ?? 'None',
                            ],
                        ];
                    @endphp
                    @foreach ($audits as $a)
                        <div
                            class="glass-card p-6 rounded-[2rem] border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900/20 shadow-sm hover:shadow-md transition-shadow">
                            <p class="text-[10px] font-black {{ $a['color'] }} uppercase tracking-widest mb-3">
                                {{ __($a['label']) }}</p>
                            <p class="text-sm font-black text-text-primary truncate">{{ $a['user'] }}
                            </p>
                            <p class="text-[11px] font-bold text-text-primary mt-1">{{ $a['date'] }}
                            </p>
                        </div>
                    @endforeach
                </div>

                {{-- Security & Session --}}
                <div
                    class="glass-card rounded-[2.5rem] p-8 border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900/30 shadow-xl overflow-hidden relative">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative z-10">
                        <div class="space-y-6">
                            <h4
                                class="text-[10px] font-black text-text-primary uppercase tracking-widest">
                                {{ __('Security Markers') }}</h4>
                            <div class="space-y-4">
                                @foreach (['Email Verified' => $user->email_verified_at, 'Phone Verified' => $user->phone_verified_at] as $l => $v)
                                    <div class="flex flex-col gap-1">
                                        <span
                                            class="text-[10px] font-bold text-text-primary uppercase">{{ $l }}</span>
                                        <span
                                            class="text-xs font-black text-text-primary">{{ $v ?? 'Pending Verification' }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h4
                                class="text-[10px] font-black text-text-primary uppercase tracking-widest">
                                {{ __('Legal Compliance') }}</h4>
                            <div class="space-y-4">
                                @foreach (['Terms Accepted' => $user->terms_accepted_at, 'Privacy Accepted' => $user->privacy_accepted_at] as $l => $v)
                                    <div class="flex flex-col gap-1">
                                        <span
                                            class="text-[10px] font-bold text-text-primary uppercase">{{ $l }}</span>
                                        <span
                                            class="text-xs font-black text-text-primary">{{ $v ?? 'Not Signed' }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h4
                                class="text-[10px] font-black text-text-primary uppercase tracking-widest">
                                {{ __('Last Session Info') }}</h4>
                            <div
                                class="p-5 rounded-[1.5rem]  dark:bg-primary-500/5 border border-zinc-100 dark:border-primary-500/10 shadow-inner">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-white dark:bg-zinc-800 rounded-xl shadow-sm">
                                        <flux:icon name="map-pin" class="w-5 h-5 text-primary-500" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-text-primary">
                                            {{ $user->last_login_ip ?? '0.0.0.0' }}</p>
                                        <p class="text-[10px] text-text-primary font-bold uppercase">
                                            {{ __('Last Sync:') }} {{ $user->last_synced_at ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .glass-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .light .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }
    </style>
</div>
