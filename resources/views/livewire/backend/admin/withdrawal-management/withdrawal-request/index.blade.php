<div>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                {{ __('Withdrawal Requests List') }}
            </h2>
        </div>
    </div>


    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions"
        emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-y-visible" />
</div>
