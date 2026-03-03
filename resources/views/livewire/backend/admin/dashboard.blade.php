<main>
    <section>
        {{-- ============================================================  Filter Bar  --}}
        <div class="glass-card rounded-2xl p-6 mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-text-primary">{{ __('Admin Dashboard') }}</h3>
                    @if ($filter === 'real_time')
                        <div class="flex items-center gap-2 mt-1">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                            <p class="text-text-muted text-sm">{{ __('Live — last 7 days, refreshing every 5s') }}</p>
                        </div>
                    @endif
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <flux:select wire:model.live="filter" class="w-auto! min-w-[160px]">
                        <flux:select.option value="real_time">{{ __('Real Time (7d)') }}</flux:select.option>
                        <flux:select.option value="current_week">{{ __('Current Week') }}</flux:select.option>
                        <flux:select.option value="current_month">{{ __('Current Month') }}</flux:select.option>
                        <flux:select.option value="current_year">{{ __('Current Year') }}</flux:select.option>
                        <flux:select.option value="custom_range">{{ __('Custom Range') }}</flux:select.option>
                    </flux:select>
                    @if ($filter === 'custom_range')
                        <flux:input type="date" wire:model.live.debounce.500ms="startDate" class="w-auto!" />
                        <flux:input type="date" wire:model.live.debounce.500ms="endDate" class="w-auto!" />
                    @endif
                    <flux:button wire:click="refreshData" variant="ghost" icon="arrow-path" size="sm">
                        {{ __('Refresh') }}</flux:button>
                </div>
            </div>
        </div>

        {{-- Loading Skeleton --}}
        <div wire:loading.delay wire:target="filter,startDate,endDate,refreshData,resetFilter">
            <x-ui.dashboard-skeleton />
        </div>

        {{-- Main Content --}}
        <div wire:loading.delay.remove wire:target="filter,startDate,endDate,refreshData,resetFilter"
            @if ($filter === 'real_time') wire:poll.5s="refreshData" @endif>

            @if ($isEmpty)
                <x-ui.empty-state icon="chart-bar" :title="__('No Data Available')" :message="__(
                    'There is no data for the selected time range. Try changing the filter or resetting to the default.',
                )">
                    <x-slot:action>
                        <flux:button wire:click="resetFilter" variant="primary" icon="arrow-path">
                            {{ __('Reset Filter') }}</flux:button>
                    </x-slot:action>
                </x-ui.empty-state>
            @else
                {{-- ===== Stat Cards ===== --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
                    <x-ui.stat-card icon="users" :label="__('New Users')" :value="$stats['total_users'] ?? 0" :growth="$stats['users_growth'] ?? 0" color="blue"
                        :progress="min(($stats['total_users'] ?? 0) > 0 ? 75 : 0, 100)" />
                    <x-ui.stat-card icon="banknotes" :label="__('Revenue')" :value="$stats['total_revenue'] ?? 0" :growth="$stats['revenue_growth'] ?? 0"
                        color="green" :progress="min(($stats['total_revenue'] ?? 0) > 0 ? 60 : 0, 100)" prefix="$" />
                    <x-ui.stat-card icon="shopping-bag" :label="__('Orders')" :value="$stats['total_orders'] ?? 0" :growth="$stats['orders_growth'] ?? 0"
                        color="purple" :progress="min(($stats['total_orders'] ?? 0) > 0 ? 55 : 0, 100)" />
                    <x-ui.stat-card icon="user-group" :label="__('New Sellers')" :value="$stats['total_sellers'] ?? 0" :growth="$stats['sellers_growth'] ?? 0"
                        color="yellow" :progress="min(($stats['total_sellers'] ?? 0) > 0 ? 40 : 0, 100)" />
                </div>

                {{-- ===== CHART 1: Financial Flow (Area — full width) ===== --}}
                <div class="glass-card rounded-2xl p-6 mb-6" wire:ignore>
                    <div x-data="financialFlowChart(@js($financialFlowData))">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-2">
                            <div>
                                <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Financial Flow') }}</h3>
                                <p class="text-text-muted text-sm">
                                    {{ __('Payments received vs seller payouts — the gap is your float') }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="inline-flex items-center gap-2 text-sm text-text-muted"><span
                                        class="w-4 h-0.5 rounded bg-[#10B981] inline-block"></span>{{ __('Payments In') }}</span>
                                <span class="inline-flex items-center gap-2 text-sm text-text-muted"><span
                                        class="w-4 h-0.5 rounded bg-[#F59E0B] inline-block"></span>{{ __('Seller Payouts') }}</span>
                            </div>
                        </div>
                        <template x-if="data.hasData">
                            <div x-ref="chart" class="w-full" style="min-height:300px;"></div>
                        </template>
                        <template x-if="!data.hasData">
                            @include('components.chart-empty', [
                                'icon' => 'banknotes',
                                'label' => __('No financial transactions yet'),
                                'hint' => __('Data appears once payments are processed.'),
                            ])
                        </template>
                    </div>
                </div>

                {{-- ===== ROW 2: Order Lifecycle + Revenue by Game ===== --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="glass-card rounded-2xl p-6" wire:ignore>
                        <div x-data="orderLifecycleChart(@js($orderLifecycleData))">
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Order Lifecycle') }}</h3>
                                <p class="text-text-muted text-sm">{{ __('Escrowed, delivered & cancelled orders') }}
                                </p>
                            </div>
                            <template x-if="data.hasData">
                                <div x-ref="chart" class="w-full" style="min-height:300px;"></div>
                            </template>
                            <template x-if="!data.hasData">
                                @include('components.chart-empty', [
                                    'icon' => 'shopping-bag',
                                    'label' => __('No orders in this period'),
                                    'hint' => __('Order breakdown appears once orders are placed.'),
                                ])
                            </template>
                        </div>
                    </div>
                    <div class="glass-card rounded-2xl p-6" wire:ignore>
                        <div x-data="revenueByGameChart(@js($revenueByGameData))">
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Revenue by Game') }}</h3>
                                <p class="text-text-muted text-sm">{{ __('Top 10 games by total revenue') }}</p>
                            </div>
                            <template x-if="data.hasData">
                                <div x-ref="chart" class="w-full" style="min-height:300px;"></div>
                            </template>
                            <template x-if="!data.hasData">
                                @include('components.chart-empty', [
                                    'icon' => 'puzzle-piece',
                                    'label' => __('No game revenue yet'),
                                    'hint' => __('Revenue appears once game product orders complete.'),
                                ])
                            </template>
                        </div>
                    </div>
                </div>

                {{-- ===== ROW 3: Revenue by Category + Withdrawal Queue ===== --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="glass-card rounded-2xl p-6" wire:ignore>
                        <div x-data="revenueByGameCategoryChart(@js($revenueByGameCategoryData))">
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Revenue by Category') }}
                                </h3>
                                <p class="text-text-muted text-sm">{{ __('Top 10 categories by total revenue') }}</p>
                            </div>
                            <template x-if="data.hasData">
                                <div x-ref="chart" class="w-full" style="min-height:300px;"></div>
                            </template>
                            <template x-if="!data.hasData">
                                @include('components.chart-empty', [
                                    'icon' => 'tag',
                                    'label' => __('No category revenue yet'),
                                    'hint' => __('Category breakdown appears once orders complete.'),
                                ])
                            </template>
                        </div>
                    </div>
                    <div class="glass-card rounded-2xl p-6" wire:ignore>
                        <div x-data="withdrawalQueueChart(@js($withdrawalQueueData))">
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Withdrawal Queue') }}</h3>
                                <p class="text-text-muted text-sm">{{ __('Payout requests by current status') }}</p>
                            </div>
                            <template x-if="data.hasData">
                                <div x-ref="chart" class="w-full" style="min-height:300px;"></div>
                            </template>
                            <template x-if="!data.hasData">
                                @include('components.chart-empty', [
                                    'icon' => 'banknotes',
                                    'label' => __('No withdrawal requests'),
                                    'hint' => __('Requests appear once sellers submit payouts.'),
                                ])
                            </template>
                        </div>
                    </div>
                </div>

                {{-- ===== CHART 5: Profit & Commission (full width) ===== --}}
                <div class="glass-card rounded-2xl p-6 mb-6" wire:ignore>
                    <div x-data="profitCommissionChart(@js($profitCommissionData))">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-2">
                            <div>
                                <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Profit & Commission') }}
                                </h3>
                                <p class="text-text-muted text-sm">
                                    {{ __('Total sales volume vs your platform commission') }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="inline-flex items-center gap-2 text-sm text-text-muted"><span
                                        class="w-3 h-3 rounded-sm bg-[#8B5CF6] inline-block"></span>{{ __('Sales Volume') }}</span>
                                <span class="inline-flex items-center gap-2 text-sm text-text-muted"><span
                                        class="w-3 h-3 rounded-sm bg-[#10B981] inline-block"></span>{{ __('Platform Profit') }}</span>
                            </div>
                        </div>
                        <template x-if="data.hasData">
                            <div x-ref="chart" class="w-full" style="min-height:300px;"></div>
                        </template>
                        <template x-if="!data.hasData">
                            @include('components.chart-empty', [
                                'icon' => 'chart-bar',
                                'label' => __('No commission data yet'),
                                'hint' => __('Profit data appears once buyers complete payments.'),
                            ])
                        </template>
                    </div>
                </div>

                {{-- ===== ROW 4: Top Sellers + Escrow Health ===== --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    {{-- CHART 8: Top Sellers --}}
                    <div class="glass-card rounded-2xl p-6" wire:ignore>
                        <div x-data="topSellersChart(@js($topSellersData))">
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Top Sellers') }}</h3>
                                <p class="text-text-muted text-sm">{{ __('Top 10 sellers by revenue this period') }}
                                </p>
                            </div>
                            <template x-if="data.hasData">
                                <div x-ref="chart" class="w-full" style="min-height:300px;"></div>
                            </template>
                            <template x-if="!data.hasData">
                                @include('components.chart-empty', [
                                    'icon' => 'trophy',
                                    'label' => __('No seller revenue yet'),
                                    'hint' => __('Top sellers appear once orders are completed.'),
                                ])
                            </template>
                        </div>
                    </div>
                    {{-- CHART 9: Escrow Health --}}
                    <div class="glass-card rounded-2xl p-6" wire:ignore>
                        <div x-data="escrowHealthChart(@js($escrowHealthData))">
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-2">
                                <div>
                                    <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Escrow Health') }}
                                    </h3>
                                    <p class="text-text-muted text-sm">
                                        {{ __('Collected payments vs seller withdrawals — gap is your escrow') }}</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="inline-flex items-center gap-2 text-sm text-text-muted"><span
                                            class="w-4 h-0.5 rounded bg-[#6366F1] inline-block"></span>{{ __('Collected') }}</span>
                                    <span class="inline-flex items-center gap-2 text-sm text-text-muted"><span
                                            class="w-4 h-0.5 rounded bg-[#F59E0B] inline-block"></span>{{ __('Withdrawn') }}</span>
                                </div>
                            </div>
                            <template x-if="data.hasData">
                                <div x-ref="chart" class="w-full" style="min-height:300px;"></div>
                            </template>
                            <template x-if="!data.hasData">
                                @include('components.chart-empty', [
                                    'icon' => 'shield-check',
                                    'label' => __('No escrow data yet'),
                                    'hint' => __('Escrow health appears once payments are collected.'),
                                ])
                            </template>
                        </div>
                    </div>
                </div>

                {{-- ===== ROW 5: Buyer Activity + Dispute & Refund ===== --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    {{-- CHART 10: Buyer Activity --}}
                    <div class="glass-card rounded-2xl p-6" wire:ignore>
                        <div x-data="buyerActivityChart(@js($buyerActivityData))">
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-2">
                                <div>
                                    <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Buyer Activity') }}
                                    </h3>
                                    <p class="text-text-muted text-sm">
                                        {{ __('New buyers vs returning buyers over time') }}</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="inline-flex items-center gap-2 text-sm text-text-muted"><span
                                            class="w-4 h-0.5 rounded bg-[#3B82F6] inline-block"></span>{{ __('New') }}</span>
                                    <span class="inline-flex items-center gap-2 text-sm text-text-muted"><span
                                            class="w-4 h-0.5 rounded bg-[#10B981] inline-block"></span>{{ __('Returning') }}</span>
                                </div>
                            </div>
                            <template x-if="data.hasData">
                                <div x-ref="chart" class="w-full" style="min-height:300px;"></div>
                            </template>
                            <template x-if="!data.hasData">
                                @include('components.chart-empty', [
                                    'icon' => 'users',
                                    'label' => __('No buyer data yet'),
                                    'hint' => __('Buyer activity appears once orders are placed.'),
                                ])
                            </template>
                        </div>
                    </div>
                    {{-- CHART 11: Dispute & Refund Rate --}}
                    <div class="glass-card rounded-2xl p-6" wire:ignore>
                        <div x-data="disputeRefundChart(@js($disputeRefundData))">
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-2">
                                <div>
                                    <h3 class="text-xl font-bold text-text-primary mb-1">
                                        {{ __('Disputes & Refunds') }}</h3>
                                    <p class="text-text-muted text-sm">
                                        {{ __('Platform health — rising values need attention') }}</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="inline-flex items-center gap-2 text-sm text-text-muted"><span
                                            class="w-4 h-0.5 rounded bg-[#EF4444] inline-block"></span>{{ __('Disputed') }}</span>
                                    <span class="inline-flex items-center gap-2 text-sm text-text-muted"><span
                                            class="w-4 h-0.5 rounded bg-[#F59E0B] inline-block"></span>{{ __('Refunded') }}</span>
                                </div>
                            </div>
                            <template x-if="data.hasData">
                                <div x-ref="chart" class="w-full" style="min-height:300px;"></div>
                            </template>
                            <template x-if="!data.hasData">
                                @include('components.chart-empty', [
                                    'icon' => 'exclamation-triangle',
                                    'label' => __('No disputes or refunds'),
                                    'hint' => __('Great! No disputes or refunds in this period.'),
                                ])
                            </template>
                        </div>
                    </div>
                </div>

                {{-- ===== CHART 7: Seller Engagement (Line — full width) ===== --}}
                <div class="glass-card rounded-2xl p-6" wire:ignore>
                    <div x-data="sellerEngagementChart(@js($sellerEngagementData))">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-2">
                            <div>
                                <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Seller Engagement') }}
                                </h3>
                                <p class="text-text-muted text-sm">
                                    {{ __('New product listings vs new seller sign-ups over time') }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="inline-flex items-center gap-2 text-sm text-text-muted"><span
                                        class="w-4 h-0.5 rounded bg-[#8B5CF6] inline-block"></span>{{ __('Listings') }}</span>
                                <span class="inline-flex items-center gap-2 text-sm text-text-muted"><span
                                        class="w-4 h-0.5 rounded bg-[#EC4899] inline-block"></span>{{ __('New Sellers') }}</span>
                            </div>
                        </div>
                        <template x-if="data.hasData">
                            <div x-ref="chart" class="w-full" style="min-height:300px;"></div>
                        </template>
                        <template x-if="!data.hasData">
                            @include('components.chart-empty', [
                                'icon' => 'user-group',
                                'label' => __('No seller activity yet'),
                                'hint' => __('Listings and sign-ups appear here once sellers join.'),
                            ])
                        </template>
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>

@script
    <script>
        /* ============================================================
         *  THEME + BASE HELPERS
         * ============================================================ */
        const isDark = () =>
            document.documentElement.classList.contains('dark') ||
            document.body.classList.contains('dark') ||
            window.matchMedia('(prefers-color-scheme: dark)').matches;

        const theme = () => ({
            fg: isDark() ? '#94a3b8' : '#64748b',
            grid: isDark() ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)',
            tip: isDark() ? 'dark' : 'light',
        });

        const baseChart = (o = {}) => ({
            fontFamily: 'Inter, ui-sans-serif, sans-serif',
            toolbar: {
                show: false
            },
            foreColor: theme().fg,
            background: 'transparent',
            animations: {
                enabled: true,
                speed: 400,
                easing: 'easeinout'
            },
            ...o,
        });

        const gridOpts = () => ({
            borderColor: theme().grid,
            strokeDashArray: 3,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            },
            padding: {
                left: 4,
                right: 4
            },
        });

        const donutOpts = (series, labels, colors, t) => {
            const total = (series || []).reduce((a, b) => a + b, 0);
            return {
                chart: baseChart({
                    type: 'donut',
                    height: 300
                }),
                series,
                labels,
                colors,
                stroke: {
                    width: 0
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '68%',
                            labels: {
                                show: true,
                                name: {
                                    fontSize: '14px',
                                    fontWeight: 600,
                                    color: t.fg,
                                    offsetY: -4
                                },
                                value: {
                                    fontSize: '26px',
                                    fontWeight: 700,
                                    color: t.fg,
                                    offsetY: 4,
                                    formatter: v => Number(v).toLocaleString()
                                },
                                total: {
                                    show: true,
                                    label: 'Total',
                                    fontSize: '13px',
                                    fontWeight: 500,
                                    color: t.fg,
                                    formatter: () => total.toLocaleString()
                                },
                            }
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    fontSize: '13px',
                    markers: {
                        radius: 4
                    }
                },
                tooltip: {
                    theme: t.tip
                },
                dataLabels: {
                    enabled: false
                },
            };
        };

        const $fmt = v => '$' + Number(v).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        const $fmtN = v => Math.round(v);

        function safeDestroy(c) {
            try {
                c?.destroy();
            } catch (_) {}
            return null;
        }

        function onUpdate(fn) {
            return Livewire.on('charts-updated', ([p]) => fn(p));
        }

        function mkChart(el, opts) {
            if (!el) return null;
            const c = new ApexCharts(el, opts);
            c.render();
            return c;
        }

        /* ── shared update handler factory ────────────────────────── */
        function makeUpdater(ctx, key, buildOpts) {
            return onUpdate(p => {
                if (!p[key]) return;
                ctx.data = p[key];
                if (!ctx.data.hasData) {
                    ctx.chart = safeDestroy(ctx.chart);
                    return;
                }
                if (!ctx.chart) {
                    ctx.$nextTick(() => ctx.init());
                    return;
                }
                buildOpts(ctx.chart, p[key]);
            });
        }

        /* ============================================================
         *  CHART 1 — Financial Flow (Area)
         * ============================================================ */
        Alpine.data('financialFlowChart', initial => ({
            chart: null,
            data: initial,
            _off: null,
            init() {
                if (!this.data.hasData || typeof ApexCharts === 'undefined') return;
                this.chart = safeDestroy(this.chart);
                this.$nextTick(() => {
                    const t = theme();
                    this.chart = mkChart(this.$refs.chart, {
                        chart: baseChart({
                            type: 'area',
                            height: 300
                        }),
                        series: this.data.series,
                        xaxis: {
                            categories: this.data.labels,
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            labels: {
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: $fmt,
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        colors: ['#10B981', '#F59E0B'],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                type: 'vertical',
                                shadeIntensity: 1,
                                opacityFrom: 0.3,
                                opacityTo: 0.02,
                                stops: [0, 100]
                            }
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        grid: gridOpts(),
                        markers: {
                            size: 0,
                            hover: {
                                size: 5
                            }
                        },
                        tooltip: {
                            theme: t.tip,
                            shared: true,
                            intersect: false,
                            y: {
                                formatter: $fmt
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false
                        },
                    });
                });
                this._off = makeUpdater(this, 'financialFlow', (chart, d) => {
                    chart.updateOptions({
                        xaxis: {
                            categories: d.labels
                        }
                    }, false, false);
                    chart.updateSeries(d.series, false);
                });
            },
            destroy() {
                if (this._off) this._off();
                this.chart = safeDestroy(this.chart);
            },
        }));

        /* ============================================================
         *  CHART 2 — Order Lifecycle (Donut)
         * ============================================================ */
        Alpine.data('orderLifecycleChart', initial => ({
            chart: null,
            data: initial,
            _off: null,
            init() {
                if (!this.data.hasData || typeof ApexCharts === 'undefined') return;
                this.chart = safeDestroy(this.chart);
                this.$nextTick(() => {
                    this.chart = mkChart(this.$refs.chart,
                        donutOpts(this.data.series, this.data.labels, ['#F59E0B', '#10B981',
                            '#EF4444'
                        ], theme()));
                });
                this._off = makeUpdater(this, 'orderLifecycle', (chart, d) => {
                    chart.updateOptions({
                        labels: d.labels
                    }, false, false);
                    chart.updateSeries(d.series, false);
                });
            },
            destroy() {
                if (this._off) this._off();
                this.chart = safeDestroy(this.chart);
            },
        }));

        /* ============================================================
         *  CHART 3 — Revenue by Game (Horizontal Bar)
         * ============================================================ */
        Alpine.data('revenueByGameChart', initial => ({
            chart: null,
            data: initial,
            _off: null,
            init() {
                if (!this.data.hasData || typeof ApexCharts === 'undefined') return;
                this.chart = safeDestroy(this.chart);
                this.$nextTick(() => {
                    const t = theme();
                    this.chart = mkChart(this.$refs.chart, {
                        chart: baseChart({
                            type: 'bar',
                            height: 300
                        }),
                        series: [{
                            name: 'Revenue',
                            data: this.data.series
                        }],
                        xaxis: {
                            categories: this.data.labels,
                            labels: {
                                formatter: $fmt,
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                                borderRadius: 5,
                                barHeight: '55%'
                            }
                        },
                        colors: ['#8B5CF6'],
                        grid: gridOpts(),
                        tooltip: {
                            theme: t.tip,
                            y: {
                                formatter: $fmt
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                    });
                });
                this._off = makeUpdater(this, 'revenueByGame', (chart, d) => {
                    chart.updateOptions({
                        xaxis: {
                            categories: d.labels
                        }
                    }, false, false);
                    chart.updateSeries([{
                        name: 'Revenue',
                        data: d.series
                    }], false);
                });
            },
            destroy() {
                if (this._off) this._off();
                this.chart = safeDestroy(this.chart);
            },
        }));

        /* ============================================================
         *  CHART 4 — Revenue by Game Category (Horizontal Bar)
         * ============================================================ */
        Alpine.data('revenueByGameCategoryChart', initial => ({
            chart: null,
            data: initial,
            _off: null,
            init() {
                if (!this.data.hasData || typeof ApexCharts === 'undefined') return;
                this.chart = safeDestroy(this.chart);
                this.$nextTick(() => {
                    const t = theme();
                    this.chart = mkChart(this.$refs.chart, {
                        chart: baseChart({
                            type: 'bar',
                            height: 300
                        }),
                        series: [{
                            name: 'Revenue',
                            data: this.data.series
                        }],
                        xaxis: {
                            categories: this.data.labels,
                            labels: {
                                formatter: $fmt,
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                                borderRadius: 5,
                                barHeight: '55%'
                            }
                        },
                        colors: ['#EC4899'],
                        grid: gridOpts(),
                        tooltip: {
                            theme: t.tip,
                            y: {
                                formatter: $fmt
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                    });
                });
                this._off = makeUpdater(this, 'revenueByGameCategory', (chart, d) => {
                    chart.updateOptions({
                        xaxis: {
                            categories: d.labels
                        }
                    }, false, false);
                    chart.updateSeries([{
                        name: 'Revenue',
                        data: d.series
                    }], false);
                });
            },
            destroy() {
                if (this._off) this._off();
                this.chart = safeDestroy(this.chart);
            },
        }));

        /* ============================================================
         *  CHART 5 — Profit & Commission (Grouped Columns)
         * ============================================================ */
        Alpine.data('profitCommissionChart', initial => ({
            chart: null,
            data: initial,
            _off: null,
            init() {
                if (!this.data.hasData || typeof ApexCharts === 'undefined') return;
                this.chart = safeDestroy(this.chart);
                this.$nextTick(() => {
                    const t = theme();
                    this.chart = mkChart(this.$refs.chart, {
                        chart: baseChart({
                            type: 'bar',
                            height: 300
                        }),
                        series: this.data.series,
                        xaxis: {
                            categories: this.data.labels,
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            labels: {
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: $fmt,
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '48%',
                                borderRadius: 4,
                                borderRadiusApplication: 'end'
                            }
                        },
                        colors: ['#8B5CF6', '#10B981'],
                        grid: gridOpts(),
                        tooltip: {
                            theme: t.tip,
                            shared: true,
                            intersect: false,
                            y: {
                                formatter: $fmt
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false
                        },
                    });
                });
                this._off = makeUpdater(this, 'profitCommission', (chart, d) => {
                    chart.updateOptions({
                        xaxis: {
                            categories: d.labels
                        }
                    }, false, false);
                    chart.updateSeries(d.series, false);
                });
            },
            destroy() {
                if (this._off) this._off();
                this.chart = safeDestroy(this.chart);
            },
        }));

        /* ============================================================
         *  CHART 6 — Withdrawal Queue (Donut)
         * ============================================================ */
        Alpine.data('withdrawalQueueChart', initial => ({
            chart: null,
            data: initial,
            _off: null,
            init() {
                if (!this.data.hasData || typeof ApexCharts === 'undefined') return;
                this.chart = safeDestroy(this.chart);
                this.$nextTick(() => {
                    this.chart = mkChart(this.$refs.chart,
                        donutOpts(this.data.series, this.data.labels,
                            this.data.colors || ['#F59E0B', '#3B82F6', '#10B981', '#EF4444'],
                            theme()));
                });
                this._off = makeUpdater(this, 'withdrawalQueue', (chart, d) => {
                    const total = (d.series || []).reduce((a, b) => a + b, 0);
                    chart.updateOptions({
                        labels: d.labels,
                        colors: d.colors,
                        plotOptions: {
                            pie: {
                                donut: {
                                    labels: {
                                        total: {
                                            formatter: () => total.toLocaleString()
                                        }
                                    }
                                }
                            }
                        },
                    }, false, false);
                    chart.updateSeries(d.series, false);
                });
            },
            destroy() {
                if (this._off) this._off();
                this.chart = safeDestroy(this.chart);
            },
        }));

        /* ============================================================
         *  CHART 7 — Seller Engagement (Smooth Line)
         * ============================================================ */
        Alpine.data('sellerEngagementChart', initial => ({
            chart: null,
            data: initial,
            _off: null,
            init() {
                if (!this.data.hasData || typeof ApexCharts === 'undefined') return;
                this.chart = safeDestroy(this.chart);
                this.$nextTick(() => {
                    const t = theme();
                    this.chart = mkChart(this.$refs.chart, {
                        chart: baseChart({
                            type: 'line',
                            height: 300
                        }),
                        series: this.data.series,
                        xaxis: {
                            categories: this.data.labels,
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            labels: {
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: $fmtN,
                                style: {
                                    colors: t.fg
                                }
                            },
                            min: 0
                        },
                        colors: ['#8B5CF6', '#EC4899'],
                        stroke: {
                            curve: 'smooth',
                            width: 2.5
                        },
                        markers: {
                            size: 4,
                            strokeWidth: 0,
                            hover: {
                                size: 6
                            }
                        },
                        grid: gridOpts(),
                        tooltip: {
                            theme: t.tip,
                            shared: true,
                            intersect: false
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false
                        },
                    });
                });
                this._off = makeUpdater(this, 'sellerEngagement', (chart, d) => {
                    chart.updateOptions({
                        xaxis: {
                            categories: d.labels
                        }
                    }, false, false);
                    chart.updateSeries(d.series, false);
                });
            },
            destroy() {
                if (this._off) this._off();
                this.chart = safeDestroy(this.chart);
            },
        }));

        /* ============================================================
         *  CHART 8 — Top Sellers (Horizontal Bar with custom tooltip)
         * ============================================================ */
        Alpine.data('topSellersChart', initial => ({
            chart: null,
            data: initial,
            _off: null,
            init() {
                if (!this.data.hasData || typeof ApexCharts === 'undefined') return;
                this.chart = safeDestroy(this.chart);
                const orderCounts = this.data.orderCounts || [];
                this.$nextTick(() => {
                    const t = theme();
                    this.chart = mkChart(this.$refs.chart, {
                        chart: baseChart({
                            type: 'bar',
                            height: 300
                        }),
                        series: [{
                            name: 'Revenue',
                            data: this.data.series
                        }],
                        xaxis: {
                            categories: this.data.labels,
                            labels: {
                                formatter: $fmt,
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                                borderRadius: 5,
                                barHeight: '55%',
                                dataLabels: {
                                    position: 'right'
                                }
                            }
                        },
                        colors: ['#F97316'],
                        grid: gridOpts(),
                        tooltip: {
                            theme: t.tip,
                            custom: ({
                                    dataPointIndex
                                }) =>
                                `<div class="apexcharts-tooltip-box" style="padding:8px 12px;font-size:13px">
                        <b>${this.data.labels[dataPointIndex]}</b><br>
                        Revenue: <b>${$fmt(this.data.series[dataPointIndex])}</b><br>
                        Orders: <b>${orderCounts[dataPointIndex] ?? 0}</b>
                    </div>`
                        },
                        dataLabels: {
                            enabled: false
                        },
                    });
                });
                this._off = makeUpdater(this, 'topSellers', (chart, d) => {
                    chart.updateOptions({
                        xaxis: {
                            categories: d.labels
                        }
                    }, false, false);
                    chart.updateSeries([{
                        name: 'Revenue',
                        data: d.series
                    }], false);
                });
            },
            destroy() {
                if (this._off) this._off();
                this.chart = safeDestroy(this.chart);
            },
        }));

        /* ============================================================
         *  CHART 9 — Escrow Health (Stacked Area)
         * ============================================================ */
        Alpine.data('escrowHealthChart', initial => ({
            chart: null,
            data: initial,
            _off: null,
            init() {
                if (!this.data.hasData || typeof ApexCharts === 'undefined') return;
                this.chart = safeDestroy(this.chart);
                this.$nextTick(() => {
                    const t = theme();
                    this.chart = mkChart(this.$refs.chart, {
                        chart: baseChart({
                            type: 'area',
                            height: 300,
                            stacked: false
                        }),
                        series: this.data.series,
                        xaxis: {
                            categories: this.data.labels,
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            labels: {
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: $fmt,
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        colors: ['#6366F1', '#F59E0B'],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                type: 'vertical',
                                shadeIntensity: 1,
                                opacityFrom: 0.25,
                                opacityTo: 0.02,
                                stops: [0, 100]
                            }
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        grid: gridOpts(),
                        markers: {
                            size: 0,
                            hover: {
                                size: 5
                            }
                        },
                        tooltip: {
                            theme: t.tip,
                            shared: true,
                            intersect: false,
                            y: {
                                formatter: $fmt
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false
                        },
                    });
                });
                this._off = makeUpdater(this, 'escrowHealth', (chart, d) => {
                    chart.updateOptions({
                        xaxis: {
                            categories: d.labels
                        }
                    }, false, false);
                    chart.updateSeries(d.series, false);
                });
            },
            destroy() {
                if (this._off) this._off();
                this.chart = safeDestroy(this.chart);
            },
        }));

        /* ============================================================
         *  CHART 10 — Buyer Activity (Stacked Bar)
         * ============================================================ */
        Alpine.data('buyerActivityChart', initial => ({
            chart: null,
            data: initial,
            _off: null,
            init() {
                if (!this.data.hasData || typeof ApexCharts === 'undefined') return;
                this.chart = safeDestroy(this.chart);
                this.$nextTick(() => {
                    const t = theme();
                    this.chart = mkChart(this.$refs.chart, {
                        chart: baseChart({
                            type: 'bar',
                            height: 300,
                            stacked: true
                        }),
                        series: this.data.series,
                        xaxis: {
                            categories: this.data.labels,
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            labels: {
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: $fmtN,
                                style: {
                                    colors: t.fg
                                }
                            },
                            min: 0
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '50%',
                                borderRadius: 4,
                                borderRadiusApplication: 'end',
                                borderRadiusWhenStacked: 'last'
                            }
                        },
                        colors: ['#3B82F6', '#10B981'],
                        grid: gridOpts(),
                        tooltip: {
                            theme: t.tip,
                            shared: true,
                            intersect: false
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false
                        },
                    });
                });
                this._off = makeUpdater(this, 'buyerActivity', (chart, d) => {
                    chart.updateOptions({
                        xaxis: {
                            categories: d.labels
                        }
                    }, false, false);
                    chart.updateSeries(d.series, false);
                });
            },
            destroy() {
                if (this._off) this._off();
                this.chart = safeDestroy(this.chart);
            },
        }));

        /* ============================================================
         *  CHART 11 — Dispute & Refund Rate (Line)
         * ============================================================ */
        Alpine.data('disputeRefundChart', initial => ({
            chart: null,
            data: initial,
            _off: null,
            init() {
                if (!this.data.hasData || typeof ApexCharts === 'undefined') return;
                this.chart = safeDestroy(this.chart);
                this.$nextTick(() => {
                    const t = theme();
                    this.chart = mkChart(this.$refs.chart, {
                        chart: baseChart({
                            type: 'line',
                            height: 300
                        }),
                        series: this.data.series,
                        xaxis: {
                            categories: this.data.labels,
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            labels: {
                                style: {
                                    colors: t.fg
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: $fmtN,
                                style: {
                                    colors: t.fg
                                }
                            },
                            min: 0
                        },
                        colors: ['#EF4444', '#F59E0B'],
                        stroke: {
                            curve: 'smooth',
                            width: 2.5
                        },
                        markers: {
                            size: 4,
                            strokeWidth: 0,
                            hover: {
                                size: 6
                            }
                        },
                        grid: gridOpts(),
                        tooltip: {
                            theme: t.tip,
                            shared: true,
                            intersect: false
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false
                        },
                    });
                });
                this._off = makeUpdater(this, 'disputeRefund', (chart, d) => {
                    chart.updateOptions({
                        xaxis: {
                            categories: d.labels
                        }
                    }, false, false);
                    chart.updateSeries(d.series, false);
                });
            },
            destroy() {
                if (this._off) this._off();
                this.chart = safeDestroy(this.chart);
            },
        }));
    </script>
@endscript
