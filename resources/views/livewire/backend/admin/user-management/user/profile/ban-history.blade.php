<div class="max-w-[1600px] mx-auto p-4 lg:p-8 space-y-8">
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                {{ __('Ban History') }}
            </h2>
            <p class="text-sm text-zinc-600 dark:text-zinc-300 mt-1">
                {{ __('Review all ban actions applied to this user over time.') }}
            </p>
        </div>

        <x-ui.button href="{{ route('admin.um.user.profileInfo', $user->id) }}" class="w-auto! py-2!">
            <flux:icon name="arrow-left"
                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
            {{ __('Back to Profile') }}
        </x-ui.button>
    </div>

    <div class="glass-card rounded-[2.5rem] p-6 lg:p-8 border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900/30 shadow-xl">
        @if ($bans->isEmpty())
            <div class="py-10 text-center text-sm text-zinc-500">
                {{ __('This user has no ban history yet.') }}
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead>
                        <tr class="text-[11px] font-black uppercase tracking-widest text-zinc-500 border-b border-zinc-200 dark:border-white/10">
                            <th class="px-4 py-3">{{ __('Type') }}</th>
                            <th class="px-4 py-3">{{ __('Reason') }}</th>
                            <th class="px-4 py-3">{{ __('Banned At') }}</th>
                            <th class="px-4 py-3">{{ __('Banned By') }}</th>
                            <th class="px-4 py-3">{{ __('Expires At') }}</th>
                            <th class="px-4 py-3">{{ __('Unbanned At') }}</th>
                            <th class="px-4 py-3">{{ __('Unbanned By') }}</th>
                            <th class="px-4 py-3">{{ __('Unban Reason') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-white/5">
                        @foreach ($bans as $ban)
                            <tr class="hover:bg-zinc-50/80 dark:hover:bg-zinc-800/60 transition-colors">
                                <td class="px-4 py-3 align-top">
                                    <span
                                        class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-black uppercase {{ $ban->type->color() }}">
                                        {{ $ban->type->label() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 align-top text-sm text-zinc-800 dark:text-zinc-100 max-w-xs">
                                    {{ $ban->reason }}
                                </td>
                                <td class="px-4 py-3 align-top text-xs text-zinc-700 dark:text-zinc-200">
                                    {{ $ban->created_at?->toDayDateTimeString() ?? '—' }}
                                </td>
                                <td class="px-4 py-3 align-top text-xs text-zinc-700 dark:text-zinc-200">
                                    {{ optional($ban->bannedBy)->full_name ?? optional($ban->bannedBy)->username ?? 'System' }}
                                </td>
                                <td class="px-4 py-3 align-top text-xs text-zinc-700 dark:text-zinc-200">
                                    {{ $ban->expires_at?->toDayDateTimeString() ?? __('N/A') }}
                                </td>
                                <td class="px-4 py-3 align-top text-xs text-zinc-700 dark:text-zinc-200">
                                    {{ $ban->unbanned_at?->toDayDateTimeString() ?? __('Active / Not lifted') }}
                                </td>
                                <td class="px-4 py-3 align-top text-xs text-zinc-700 dark:text-zinc-200">
                                    {{ optional($ban->unbannedBy)->full_name ?? optional($ban->unbannedBy)->username ?? ($ban->unbanned_at ? 'System' : '—') }}
                                </td>
                                <td class="px-4 py-3 align-top text-xs text-zinc-700 dark:text-zinc-200 max-w-xs">
                                    {{ $ban->unban_reason ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

