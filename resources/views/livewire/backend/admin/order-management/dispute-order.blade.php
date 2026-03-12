<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                {{ __('Support — Dispute Orders') }}
            </h2>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="flex items-center gap-2 mb-4 border-b border-zinc-800/60 pb-2">
        <a href="{{ route('admin.orders.dispute-orders', ['tab' => 'open']) }}" wire:navigate
            class="px-4 py-2 text-sm font-medium rounded-t-lg transition {{ $tab === 'open' ? 'bg-red-500/20 text-red-400 border-b-2 border-red-400' : 'text-text-muted hover:text-text-white border border-red-100 border-b-transparent' }}">
            {{ __('Open') }}
            <span
                class="ml-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] rounded-full bg-red-500/20 text-red-400 font-semibold">{{ $openCount }}</span>
        </a>
        <a href="{{ route('admin.orders.dispute-orders', ['tab' => 'resolved']) }}" wire:navigate
            class="px-4 py-2 text-sm font-medium rounded-t-lg transition {{ $tab === 'resolved' ? 'bg-green-500/20 text-green-400 border-b-2 border-green-400' : 'text-text-muted hover:text-text-white border border-green-100 border-b-transparent' }}">
            {{ __('Resolved') }}
            <span
                class="ml-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] rounded-full bg-green-500/20 text-green-400 font-semibold">{{ $resolvedCount }}</span>
        </a>
        {{-- <a href="{{ route('admin.orders.dispute-orders', ['tab' => 'closed']) }}" wire:navigate
            class="px-4 py-2 text-sm font-medium rounded-t-lg transition {{ $tab === 'closed' ? 'bg-zinc-500/20 text-zinc-400 border-b-2 border-zinc-400' : 'text-text-muted hover:text-text-white border border-zinc-100 border-b-transparent' }}">
            {{ __('Closed') }}
            <span
                class="ml-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] rounded-full bg-zinc-500/20 text-zinc-400 font-semibold">{{ $closedCount }}</span>
        </a> --}}
    </div>

    {{-- Table Component --}}
    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions" :showRowNumber="false" :mobileVisibleColumns="2"
        searchProperty="search" perPageProperty="perPage" :showBulkActions="false"
        emptyMessage="No dispute orders found for this tab." />
</section>
