<main>
    <section>
        {{-- ============================================================
            Filter Bar
        ============================================================ --}}
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
                            <p class="text-text-muted text-sm">{{ __('Live — updating every 5s') }}</p>
                        </div>
                    @endif
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <flux:select wire:model.live="filter" class="w-auto! min-w-[160px]">
                        <flux:select.option value="real_time">{{ __('Real Time') }}</flux:select.option>
                        <flux:select.option value="current_week">{{ __('Current Week') }}</flux:select.option>
                        <flux:select.option value="current_month">{{ __('Current Month') }}</flux:select.option>
                        <flux:select.option value="current_year">{{ __('Current Year') }}</flux:select.option>
                        <flux:select.option value="custom_range">{{ __('Custom Range') }}</flux:select.option>
                    </flux:select>

                    @if ($filter === 'custom_range')
                        <flux:input type="date" wire:model.live.debounce.500ms="startDate" class="w-auto!" />
                        <flux:input type="date" wire:model.live.debounce.500ms="endDate" class="w-auto!" />
                    @endif
                </div>
            </div>
        </div>

        {{-- ============================================================
            Loading Skeleton — shown only if fetch takes > 200ms
        ============================================================ --}}
        <div wire:loading.delay wire:target="filter,startDate,endDate,refreshData,resetFilter">
            <x-ui.dashboard-skeleton />
        </div>

        {{-- ============================================================
            Main Content — conditional polling when real_time
        ============================================================ --}}
        <div wire:loading.delay.remove wire:target="filter,startDate,endDate,refreshData,resetFilter"
            @if ($filter === 'real_time') wire:poll.5s="refreshData" @endif>
            @if ($isEmpty)
                <x-ui.empty-state icon="chart-bar" :title="__('No Data Available')" :message="__(
                    'There is no data for the selected time range. Try changing the filter or resetting to the default.',
                )">
                    <x-slot:action>
                        <flux:button wire:click="resetFilter" variant="primary" icon="arrow-path">
                            {{ __('Reset Filter') }}
                        </flux:button>
                    </x-slot:action>
                </x-ui.empty-state>
            @else
                {{-- ========== Stat Cards ========== --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
                    <x-ui.stat-card icon="users" :label="__('Total Users')" :value="$stats['total_users'] ?? 0" :growth="$stats['users_growth'] ?? 0" color="blue"
                        :progress="min(($stats['total_users'] ?? 0) > 0 ? 75 : 0, 100)" />
                    <x-ui.stat-card icon="banknotes" :label="__('Total Revenue')" :value="$stats['total_revenue'] ?? 0" prefix="$"
                        :growth="$stats['revenue_growth'] ?? 0" color="green" :progress="min(($stats['total_revenue'] ?? 0) > 0 ? 60 : 0, 100)" />
                    <x-ui.stat-card icon="shopping-bag" :label="__('Total Orders')" :value="$stats['total_orders'] ?? 0" :growth="$stats['orders_growth'] ?? 0"
                        color="purple" :progress="min(($stats['total_orders'] ?? 0) > 0 ? 55 : 0, 100)" />
                    <x-ui.stat-card icon="user-group" :label="__('Total Sellers')" :value="$stats['total_sellers'] ?? 0" :growth="$stats['sellers_growth'] ?? 0"
                        color="yellow" :progress="min(($stats['total_sellers'] ?? 0) > 0 ? 40 : 0, 100)" />
                </div>

                {{-- ========== CHART 1: Financial Flow (Area) ========== --}}
                <div class="glass-card rounded-2xl p-6 mb-6" wire:ignore>
                    <div x-data="financialFlowChart(@js($financialFlowData))" x-init="init()">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-2">
                            <div>
                                <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Financial Flow') }}</h3>
                                <p class="text-text-muted text-sm">
                                    {{ __('Payments received vs seller payouts — the gap is your float') }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center gap-1.5 text-xs text-text-muted">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#10B981]"></span> {{ __('Payments In') }}
                                </span>
                                <span class="inline-flex items-center gap-1.5 text-xs text-text-muted">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#F59E0B]"></span> {{ __('Payouts') }}
                                </span>
                            </div>
                        </div>
                        <div x-ref="chart" class="w-full" style="min-height: 320px;"></div>
                    </div>
                </div>

                {{-- ========== ROW 2: Order Lifecycle + Revenue by Game ========== --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    {{-- CHART 2: Order Lifecycle (Donut) --}}
                    <div class="glass-card rounded-2xl p-6" wire:ignore>
                        <div x-data="orderLifecycleChart(@js($orderLifecycleData))" x-init="init()">
                            <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Order Lifecycle') }}</h3>
                            <p class="text-text-muted text-sm mb-6">{{ __('Escrowed, delivered & cancelled orders') }}
                            </p>
                            <div x-ref="chart" class="w-full" style="min-height: 300px;"></div>
                        </div>
                    </div>

                    {{-- CHART 3: Revenue by Game (Horizontal Bar) --}}
                    <div class="glass-card rounded-2xl p-6" wire:ignore>
                        <div x-data="revenueByGameChart(@js($revenueByGameData))" x-init="init()">
                            <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Revenue by Game') }}</h3>
                            <p class="text-text-muted text-sm mb-6">{{ __('Top games by total revenue') }}</p>
                            <div x-ref="chart" class="w-full" style="min-height: 300px;"></div>
                        </div>
                    </div>
                </div>

                {{-- ========== ROW 3: Revenue by Category + Profit & Commission ========== --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    {{-- CHART 4: Revenue by Game Category (Horizontal Bar) --}}
                    <div class="glass-card rounded-2xl p-6" wire:ignore>
                        <div x-data="revenueByGameCategoryChart(@js($revenueByGameCategoryData))" x-init="init()">
                            <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Revenue by Category') }}</h3>
                            <p class="text-text-muted text-sm mb-6">{{ __('Top categories by total revenue') }}</p>
                            <div x-ref="chart" class="w-full" style="min-height: 300px;"></div>
                        </div>
                    </div>

                    {{-- CHART 6: Withdrawal Queue (Bar) --}}
                    <div class="glass-card rounded-2xl p-6" wire:ignore>
                        <div x-data="withdrawalQueueChart(@js($withdrawalQueueData))" x-init="init()">
                            <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Withdrawal Queue') }}</h3>
                            <p class="text-text-muted text-sm mb-6">{{ __('Seller payout requests by status') }}</p>
                            <div x-ref="chart" class="w-full" style="min-height: 300px;"></div>
                        </div>
                    </div>
                </div>

                {{-- ========== CHART 5: Profit & Commission (Column — full width) ========== --}}
                <div class="glass-card rounded-2xl p-6 mb-6" wire:ignore>
                    <div x-data="profitCommissionChart(@js($profitCommissionData))" x-init="init()">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-2">
                            <div>
                                <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Profit & Commission') }}
                                </h3>
                                <p class="text-text-muted text-sm">
                                    {{ __('Total sales volume vs your platform commission') }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center gap-1.5 text-xs text-text-muted">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#8B5CF6]"></span>
                                    {{ __('Sales Volume') }}
                                </span>
                                <span class="inline-flex items-center gap-1.5 text-xs text-text-muted">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#10B981]"></span>
                                    {{ __('Platform Profit') }}
                                </span>
                            </div>
                        </div>
                        <div x-ref="chart" class="w-full" style="min-height: 320px;"></div>
                    </div>
                </div>

                {{-- ========== CHART 7: Seller Engagement (Line — full width) ========== --}}
                <div class="glass-card rounded-2xl p-6" wire:ignore>
                    <div x-data="sellerEngagementChart(@js($sellerEngagementData))" x-init="init()">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-2">
                            <div>
                                <h3 class="text-xl font-bold text-text-primary mb-1">{{ __('Seller Engagement') }}
                                </h3>
                                <p class="text-text-muted text-sm">
                                    {{ __('New product listings vs new seller sign-ups') }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center gap-1.5 text-xs text-text-muted">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#8B5CF6]"></span> {{ __('Listings') }}
                                </span>
                                <span class="inline-flex items-center gap-1.5 text-xs text-text-muted">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#EC4899]"></span> {{ __('Sellers') }}
                                </span>
                            </div>
                        </div>
                        <div x-ref="chart" class="w-full" style="min-height: 300px;"></div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>

@script
    <script>
        const isDark = () => document.documentElement.classList.contains('dark') ||
            document.body.classList.contains('dark') ||
            window.matchMedia('(prefers-color-scheme: dark)').matches;

        const theme = () => ({
            fg: isDark() ? '#9ca3af' : '#64748b',
            grid: isDark() ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)',
            tip: isDark() ? 'dark' : 'light',
            track: isDark() ? '#1f1f2e' : '#f1f5f9',
        });

        const baseChart = (extra = {}) => ({
            fontFamily: 'Inter, sans-serif',
            toolbar: {
                show: false
            },
            foreColor: theme().fg,
            background: 'transparent',
            ...extra,
        });

        const noData = (text) => ({
            text,
            align: 'center',
            verticalAlign: 'middle',
            style: {
                fontSize: '14px'
            }
        });

        const destroyChart = (instance) => {
            if (instance) {
                instance.destroy();
            }
            return null;
        };

        const listenUpdate = (ctx, key) => {
            Livewire.on('charts-updated', ([p]) => {
                if (ctx.chart && p[key]) {
                    ctx.data = p[key];
                    if (p[key].labels) {
                        ctx.chart.updateOptions({
                            xaxis: {
                                categories: p[key].labels
                            },
                            labels: p[key].labels
                        });
                    }
                    ctx.chart.updateSeries(p[key].series ?? p[key]);
                }
            });
        };

        /* ==========================================================
         *  CHART 1: Financial Flow (Area)
         * ========================================================== */
        Alpine.data('financialFlowChart', (initial) => ({
            chart: null,
            data: initial,
            init() {
                if (typeof ApexCharts === 'undefined') return;
                const t = theme();
                this.chart = new ApexCharts(this.$refs.chart, {
                    chart: baseChart({
                        type: 'area',
                        height: 320
                    }),
                    series: this.data.series,
                    xaxis: {
                        categories: this.data.labels,
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: v => '$' + Number(v).toLocaleString()
                        }
                    },
                    colors: ['#10B981', '#F59E0B'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.4,
                            opacityTo: 0.05,
                            stops: [0, 100]
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2.5
                    },
                    grid: {
                        borderColor: t.grid,
                        strokeDashArray: 4
                    },
                    tooltip: {
                        theme: t.tip,
                        shared: true,
                        intersect: false,
                        y: {
                            formatter: v => '$' + Number(v).toLocaleString()
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: false
                    },
                    noData: noData('No financial data'),
                });
                this.chart.render();
                listenUpdate(this, 'financialFlow');
            },
            destroy() {
                this.chart = destroyChart(this.chart);
            },
        }));

        /* ==========================================================
         *  CHART 2: Order Lifecycle (Donut)
         * ========================================================== */
        Alpine.data('orderLifecycleChart', (initial) => ({
            chart: null,
            data: initial,
            init() {
                if (typeof ApexCharts === 'undefined') return;
                const t = theme();
                this.chart = new ApexCharts(this.$refs.chart, {
                    chart: baseChart({
                        type: 'donut',
                        height: 300
                    }),
                    series: this.data.series,
                    labels: this.data.labels,
                    colors: ['#F59E0B', '#10B981', '#EF4444'],
                    stroke: {
                        width: 0
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: 'Total',
                                        fontWeight: 700
                                    }
                                }
                            }
                        },
                    },
                    legend: {
                        position: 'bottom',
                        fontFamily: 'Inter, sans-serif'
                    },
                    tooltip: {
                        theme: t.tip
                    },
                    dataLabels: {
                        enabled: false
                    },
                    noData: noData('No order data'),
                });
                this.chart.render();
                Livewire.on('charts-updated', ([p]) => {
                    if (this.chart && p.orderLifecycle) {
                        this.data = p.orderLifecycle;
                        this.chart.updateOptions({
                            labels: p.orderLifecycle.labels
                        });
                        this.chart.updateSeries(p.orderLifecycle.series);
                    }
                });
            },
            destroy() {
                this.chart = destroyChart(this.chart);
            },
        }));

        /* ==========================================================
         *  CHART 3: Revenue by Game (Horizontal Bar)
         * ========================================================== */
        Alpine.data('revenueByGameChart', (initial) => ({
            chart: null,
            data: initial,
            init() {
                if (typeof ApexCharts === 'undefined') return;
                const t = theme();
                this.chart = new ApexCharts(this.$refs.chart, {
                    chart: baseChart({
                        type: 'bar',
                        height: 300
                    }),
                    series: [{
                        name: 'Revenue',
                        data: this.data.series
                    }],
                    xaxis: {
                        categories: this.data.labels
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 4,
                            barHeight: '60%'
                        }
                    },
                    colors: ['#8B5CF6'],
                    grid: {
                        borderColor: t.grid,
                        strokeDashArray: 4
                    },
                    tooltip: {
                        theme: t.tip,
                        y: {
                            formatter: v => '$' + Number(v).toLocaleString()
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    noData: noData('No game revenue data'),
                });
                this.chart.render();
                Livewire.on('charts-updated', ([p]) => {
                    if (this.chart && p.revenueByGame) {
                        this.data = p.revenueByGame;
                        this.chart.updateOptions({
                            xaxis: {
                                categories: p.revenueByGame.labels
                            }
                        });
                        this.chart.updateSeries([{
                            name: 'Revenue',
                            data: p.revenueByGame.series
                        }]);
                    }
                });
            },
            destroy() {
                this.chart = destroyChart(this.chart);
            },
        }));

        /* ==========================================================
         *  CHART 4: Revenue by Game Category (Horizontal Bar)
         * ========================================================== */
        Alpine.data('revenueByGameCategoryChart', (initial) => ({
            chart: null,
            data: initial,
            init() {
                if (typeof ApexCharts === 'undefined') return;
                const t = theme();
                this.chart = new ApexCharts(this.$refs.chart, {
                    chart: baseChart({
                        type: 'bar',
                        height: 300
                    }),
                    series: [{
                        name: 'Revenue',
                        data: this.data.series
                    }],
                    xaxis: {
                        categories: this.data.labels
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 4,
                            barHeight: '60%'
                        }
                    },
                    colors: ['#EC4899'],
                    grid: {
                        borderColor: t.grid,
                        strokeDashArray: 4
                    },
                    tooltip: {
                        theme: t.tip,
                        y: {
                            formatter: v => '$' + Number(v).toLocaleString()
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    noData: noData('No category revenue data'),
                });
                this.chart.render();
                Livewire.on('charts-updated', ([p]) => {
                    if (this.chart && p.revenueByGameCategory) {
                        this.data = p.revenueByGameCategory;
                        this.chart.updateOptions({
                            xaxis: {
                                categories: p.revenueByGameCategory.labels
                            }
                        });
                        this.chart.updateSeries([{
                            name: 'Revenue',
                            data: p.revenueByGameCategory.series
                        }]);
                    }
                });
            },
            destroy() {
                this.chart = destroyChart(this.chart);
            },
        }));

        /* ==========================================================
         *  CHART 5: Profit & Commission (Grouped Column)
         * ========================================================== */
        Alpine.data('profitCommissionChart', (initial) => ({
            chart: null,
            data: initial,
            init() {
                if (typeof ApexCharts === 'undefined') return;
                const t = theme();
                this.chart = new ApexCharts(this.$refs.chart, {
                    chart: baseChart({
                        type: 'bar',
                        height: 320
                    }),
                    series: this.data.series,
                    xaxis: {
                        categories: this.data.labels,
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: v => '$' + Number(v).toLocaleString()
                        }
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '55%',
                            borderRadius: 4
                        }
                    },
                    colors: ['#8B5CF6', '#10B981'],
                    grid: {
                        borderColor: t.grid,
                        strokeDashArray: 4
                    },
                    tooltip: {
                        theme: t.tip,
                        shared: true,
                        intersect: false,
                        y: {
                            formatter: v => '$' + Number(v).toLocaleString()
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: false
                    },
                    noData: noData('No transaction data'),
                });
                this.chart.render();
                listenUpdate(this, 'profitCommission');
            },
            destroy() {
                this.chart = destroyChart(this.chart);
            },
        }));

        /* ==========================================================
         *  CHART 6: Withdrawal Queue (Bar)
         * ========================================================== */
        Alpine.data('withdrawalQueueChart', (initial) => ({
            chart: null,
            data: initial,
            init() {
                if (typeof ApexCharts === 'undefined') return;
                const t = theme();
                this.chart = new ApexCharts(this.$refs.chart, {
                    chart: baseChart({
                        type: 'bar',
                        height: 300
                    }),
                    series: [{
                        name: 'Requests',
                        data: this.data.series
                    }],
                    xaxis: {
                        categories: this.data.labels
                    },
                    plotOptions: {
                        bar: {
                            distributed: true,
                            columnWidth: '50%',
                            borderRadius: 6
                        }
                    },
                    colors: this.data.colors || ['#F59E0B', '#3B82F6', '#10B981', '#EF4444'],
                    grid: {
                        borderColor: t.grid,
                        strokeDashArray: 4
                    },
                    tooltip: {
                        theme: t.tip
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 700,
                            colors: ['#fff']
                        }
                    },
                    legend: {
                        show: false
                    },
                    noData: noData('No withdrawal data'),
                });
                this.chart.render();
                Livewire.on('charts-updated', ([p]) => {
                    if (this.chart && p.withdrawalQueue) {
                        this.data = p.withdrawalQueue;
                        this.chart.updateOptions({
                            xaxis: {
                                categories: p.withdrawalQueue.labels
                            },
                            colors: p.withdrawalQueue.colors || ['#F59E0B', '#3B82F6',
                                '#10B981', '#EF4444'
                            ],
                        });
                        this.chart.updateSeries([{
                            name: 'Requests',
                            data: p.withdrawalQueue.series
                        }]);
                    }
                });
            },
            destroy() {
                this.chart = destroyChart(this.chart);
            },
        }));

        /* ==========================================================
         *  CHART 7: Seller Engagement (Line)
         * ========================================================== */
        Alpine.data('sellerEngagementChart', (initial) => ({
            chart: null,
            data: initial,
            init() {
                if (typeof ApexCharts === 'undefined') return;
                const t = theme();
                this.chart = new ApexCharts(this.$refs.chart, {
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
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: v => Math.round(v)
                        }
                    },
                    colors: ['#8B5CF6', '#EC4899'],
                    stroke: {
                        curve: 'smooth',
                        width: 2.5
                    },
                    markers: {
                        size: 4,
                        strokeWidth: 0
                    },
                    grid: {
                        borderColor: t.grid,
                        strokeDashArray: 4
                    },
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
                    noData: noData('No engagement data'),
                });
                this.chart.render();
                listenUpdate(this, 'sellerEngagement');
            },
            destroy() {
                this.chart = destroyChart(this.chart);
            },
        }));
    </script>
@endscript
