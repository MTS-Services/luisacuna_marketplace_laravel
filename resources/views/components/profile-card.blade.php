@props([
    'user',
    'role',
    'accentClass',
    'dotClass',
    'ringClass',
    'routeHref',
    'totalOrders',
    'done',
    'cancelled',
    'trustScore',
    'wins',
    'active',
    'disputeRate',
    'country',
    'countryCode',
    'sellerSince',
    'ipMatch',
    'hasIp',
    'sameIp',
    'statsLabel',
    'dispLabel',
    'dispValue',
    'winLabel',
    'winValue',
    'repOrScore',
])


<div
    class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-800
            rounded-xl overflow-hidden shadow-sm">

    {{-- Card header --}}
    <div
        class="flex items-center justify-between px-4 py-3
                bg-gray-50 dark:bg-gray-800/60
                border-b border-gray-200 dark:border-gray-800">
        <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full {{ $dotClass }} shrink-0"></div>
            <span class="text-xs font-bold {{ $accentClass }} uppercase tracking-widest">
                {{ strtoupper($role) }}
                @if ($user)
                    <span class="text-gray-500 dark:text-gray-500 normal-case tracking-normal font-semibold ml-1">
                        : {{ $user->username }}
                    </span>
                @endif
            </span>
        </div>
        @if ($user)
            <a href="{{ $routeHref }}"
                class="text-xs text-gray-400 dark:text-gray-600
                      hover:{{ $accentClass }} transition-colors font-medium">
                {{ __('View →') }}
            </a>
        @endif
    </div>

    @if ($user)
        <div class="p-4 space-y-4">

            {{-- Avatar + name --}}
            <div class="flex items-center gap-3">
                <img src="{{ auth_storage_url($user->avatar) }}" alt="{{ $user->username }}"
                    class="w-10 h-10 rounded-full object-cover ring-2 {{ $ringClass }} shrink-0" />
                <div class="min-w-0">
                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate leading-tight">
                        {{ $user->full_name }}
                    </p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                        {{ '@' . $user->username }}
                    </p>
                </div>
            </div>

            {{-- Meta info grid --}}
            <div class="grid grid-cols-2 gap-x-4 gap-y-2.5">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-600 uppercase tracking-wider mb-0.5">
                        {{ __('Registration') }}
                    </p>
                    <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">
                        {{ $user->created_at?->format('d M Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-600 uppercase tracking-wider mb-0.5">
                        {{ __('Reg. Seller') }}
                    </p>
                    <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">
                        {{ $sellerSince ?: 'N/A' }}
                    </p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-600 uppercase tracking-wider mb-0.5">
                        {{ __('Location') }}
                    </p>
                    <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 truncate flex items-center gap-1">
                        @if ($country)
                            {{ $country }}
                            @if ($countryCode)
                                <span
                                    class="text-[10px] text-gray-400 dark:text-gray-600 uppercase">{{ $countryCode }}</span>
                            @endif
                        @else
                            <span class="text-gray-300 dark:text-gray-600">—</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-600 uppercase tracking-wider mb-0.5">
                        {{ __('IP') }}
                    </p>
                    @if ($hasIp)
                        <p class="flex items-center gap-1">
                            @if ($sameIp)
                                <span
                                    class="text-xs font-bold text-red-600 dark:text-red-400">{{ __('Match') }}</span>
                                <flux:icon name="x-circle" class="w-3.5 h-3.5 text-red-600 dark:text-red-400" />
                            @else
                                <span
                                    class="text-xs font-bold text-green-600 dark:text-green-400">{{ __('Match') }}</span>
                                <flux:icon name="check-circle" class="w-3.5 h-3.5 text-green-600 dark:text-green-400" />
                            @endif
                        </p>
                    @else
                        <p class="text-xs text-gray-300 dark:text-gray-600">—</p>
                    @endif
                </div>
            </div>

            {{-- Stat group: Shopping / Sales --}}
            <div>
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-600 uppercase tracking-widest mb-2">
                    {{ __($statsLabel) }}
                </p>
                <div class="grid grid-cols-3 gap-2">
                    @foreach ([['label' => __('Total'), 'value' => $totalOrders, 'color' => 'text-gray-900 dark:text-white'], ['label' => __('Done'), 'value' => $done, 'color' => 'text-green-600 dark:text-green-400'], ['label' => __('Cancel'), 'value' => $cancelled, 'color' => 'text-red-600 dark:text-red-400']] as $st)
                        <div
                            class="bg-gray-50 dark:bg-gray-800/70
                                    border border-gray-100 dark:border-gray-700/50
                                    rounded-xl px-2 py-2.5 text-center">
                            <p
                                class="text-[10px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-0.5">
                                {{ $st['label'] }}
                            </p>
                            <p class="text-sm font-bold {{ $st['color'] }}">{{ number_format($st['value']) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Trust & Disputes --}}
            <div>
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-600 uppercase tracking-widest mb-2">
                    {{ __('Trust & Disputes') }}
                </p>
                <div class="grid grid-cols-3 gap-2">
                    {{-- Score / Rep --}}
                    <div
                        class="bg-gray-50 dark:bg-gray-800/70
                                border border-gray-100 dark:border-gray-700/50
                                rounded-xl px-2 py-2.5 text-center">
                        <p
                            class="text-[10px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-0.5">
                            {{ $dispLabel }}
                        </p>
                        <p
                            class="text-sm font-bold
                            {{ $repOrScore >= 70 ? 'text-green-600 dark:text-green-400' : ($repOrScore >= 40 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">
                            {{ $dispValue }}
                        </p>
                    </div>
                    {{-- Won / Lost --}}
                    <div
                        class="bg-gray-50 dark:bg-gray-800/70
                                border border-gray-100 dark:border-gray-700/50
                                rounded-xl px-2 py-2.5 text-center">
                        <p
                            class="text-[10px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-0.5">
                            {{ $winLabel }}
                        </p>
                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $winValue }}</p>
                    </div>
                    {{-- Active --}}
                    <div
                        class="bg-gray-50 dark:bg-gray-800/70
                                border border-gray-100 dark:border-gray-700/50
                                rounded-xl px-2 py-2.5 text-center">
                        <p
                            class="text-[10px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-0.5">
                            {{ __('Active') }}
                        </p>
                        <p
                            class="text-sm font-bold {{ $active > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-500 dark:text-gray-500' }}">
                            {{ $active }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- High dispute rate warning --}}
            @if ($disputeRate > 50)
                <div
                    class="flex items-center gap-2
                            bg-red-50 dark:bg-red-900/15
                            border border-red-200 dark:border-red-800/30
                            rounded-xl px-3 py-2.5">
                    <flux:icon name="exclamation-triangle" class="w-4 h-4 text-red-600 dark:text-red-400 shrink-0" />
                    <p class="text-xs font-bold text-red-700 dark:text-red-400">
                        {{ __('HIGH DISPUTE RATE') }} — {{ $disputeRate }}%
                    </p>
                </div>
            @endif

        </div>
    @else
        <div class="p-6 text-center">
            <p class="text-sm text-gray-400 dark:text-gray-600">
                {{ __('User not found.') }}
            </p>
        </div>
    @endif
</div>
