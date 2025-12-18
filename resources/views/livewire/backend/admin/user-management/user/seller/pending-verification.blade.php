<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Seller Pending Verificaiton List') }}
            </h2>
        </div>
    </div>

    {{-- Table Component --}}

    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions" :mobileVisibleColumns="2" searchProperty="search" perPageProperty="perPage"
        :showBulkActions="false" emptyMessage="No Pending Verification found. Let's wait for new request" /> 
</section>
