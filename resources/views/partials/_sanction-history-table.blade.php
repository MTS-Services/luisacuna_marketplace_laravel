<table class="min-w-full text-xs border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden">
    <thead class="bg-gray-50 dark:bg-gray-800/60">
        <tr class="text-left text-[11px] font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
            <th class="px-3 py-2">{{ __('Type') }}</th>
            <th class="px-3 py-2">{{ __('Reason') }}</th>
            <th class="px-3 py-2">{{ __('Duration') }}</th>
            <th class="px-3 py-2">{{ __('Expires At') }}</th>
            <th class="px-3 py-2">{{ __('Active') }}</th>
            <th class="px-3 py-2">{{ __('Admin') }}</th>
            <th class="px-3 py-2">{{ __('Created At') }}</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse ($rows as $sanction)
            <tr class="text-xs text-gray-700 dark:text-gray-200">
                <td class="px-3 py-2">{{ $sanction->type->label() }}</td>
                <td class="px-3 py-2 max-w-xs truncate" title="{{ $sanction->reason }}">{{ $sanction->reason }}</td>
                <td class="px-3 py-2">{{ $sanction->duration ?? '—' }}</td>
                <td class="px-3 py-2">
                    {{ optional($sanction->expires_at)->format('d M Y, H:i') ?? '—' }}
                </td>
                <td class="px-3 py-2">
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $sanction->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-800/40 dark:text-gray-400' }}">
                        {{ $sanction->is_active ? __('Active') : __('Inactive') }}
                    </span>
                </td>
                <td class="px-3 py-2">{{ $sanction->admin?->name ?? '—' }}</td>
                <td class="px-3 py-2">{{ $sanction->created_at->format('d M Y, H:i') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7"
                    class="px-3 py-4 text-center text-xs text-gray-500 dark:text-gray-400">
                    {{ __('No sanctions found.') }}
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

