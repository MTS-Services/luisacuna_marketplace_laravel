<section class="space-y-6">
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm uppercase tracking-wide text-text-secondary">{{ __('Review Management') }}</p>
            <h2 class="text-2xl font-bold text-text-primary">{{ __('CMS Helpful Insights') }}</h2>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="glass-card rounded-2xl p-5 border border-success/20">
            <p class="text-sm text-success font-semibold flex items-center gap-2">
                <flux:icon name="thumbs-up" class="w-4 h-4" />
                {{ __('Helpful votes') }}
            </p>
            <p class="text-3xl font-bold text-text-primary mt-2">{{ number_format($totals['helpful']) }}</p>
        </div>

        <div class="glass-card rounded-2xl p-5 border border-danger/20">
            <p class="text-sm text-danger font-semibold flex items-center gap-2">
                <flux:icon name="thumbs-down" class="w-4 h-4" />
                {{ __('Not helpful votes') }}
            </p>
            <p class="text-3xl font-bold text-text-primary mt-2">{{ number_format($totals['not_helpful']) }}</p>
        </div>

        <div class="glass-card rounded-2xl p-5 border border-info/20">
            <p class="text-sm text-info font-semibold flex items-center gap-2">
                <flux:icon name="chart-bar" class="w-4 h-4" />
                {{ __('Total interactions') }}
            </p>
            <p class="text-3xl font-bold text-text-primary mt-2">{{ number_format($totals['total']) }}</p>
        </div>
    </div>

    {{-- Page-wise Table --}}
    <div class="glass-card rounded-2xl p-0 overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
            <div>
                <p class="text-lg font-semibold text-text-primary">{{ __('Page wise feedback') }}</p>
                <p class="text-sm text-text-secondary">{{ __('Helpful / Not helpful votes for each CMS page.') }}</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/5">
                <thead>
                    <tr
                        class="bg-bg-secondary/50 text-left text-xs font-semibold uppercase tracking-wider text-text-secondary">
                        <th class="px-6 py-3">{{ __('Page') }}</th>
                        <th class="px-6 py-3 text-center">{{ __('Helpful') }}</th>
                        <th class="px-6 py-3 text-center">{{ __('Not helpful') }}</th>
                        <th class="px-6 py-3 text-center">{{ __('Total votes') }}</th>
                        <th class="px-6 py-3 text-center">{{ __('Helpful ratio') }}</th>
                        <th class="px-6 py-3">{{ __('Last feedback') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($pages as $page)
                        @php
                            $totalVotes = $page->helpful_positive_count + $page->helpful_negative_count;
                            $helpfulRatio =
                                $totalVotes > 0 ? round(($page->helpful_positive_count / $totalVotes) * 100) : 0;
                        @endphp
                        <tr class="hover:bg-bg-secondary/40">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-text-primary">{{ $page->type?->label() ?? __('Unknown') }}
                                </p>
                                <p class="text-xs text-text-secondary">
                                    {{ ucfirst(str_replace('_', ' ', $page->type->value ?? '')) }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-success/10 text-success text-sm font-semibold">
                                    {{ $page->helpful_positive_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-danger/10 text-danger text-sm font-semibold">
                                    {{ $page->helpful_negative_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-semibold text-text-primary">{{ $totalVotes }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="text-text-primary font-semibold">{{ $helpfulRatio }}%</span>
                                    <div class="w-32 h-2 bg-bg-secondary rounded-full overflow-hidden mt-1">
                                        <div class="h-full bg-success" style="width: {{ $helpfulRatio }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($page->latestHelpful)
                                    <div class="flex items-center gap-2 text-sm">
                                        <flux:icon name="clock" class="w-4 h-4 text-text-secondary" />
                                        <span
                                            class="text-text-secondary">{{ $page->latestHelpful->created_at->diffForHumans() }}</span>
                                    </div>
                                @else
                                    <span class="text-sm text-text-secondary">{{ __('No votes yet') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-text-secondary">
                                <div class="flex flex-col items-center gap-2">
                                    <flux:icon name="inbox" class="w-8 h-8 text-text-secondary/60" />
                                    <p class="font-medium">{{ __('No CMS pages found') }}</p>
                                    <p class="text-sm">{{ __('Create CMS content to start collecting feedback.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
