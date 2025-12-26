<section>
    {{-- Page Header --}}
    {{-- <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                {{ __('Paid Orders List') }}
            </h2>
        </div>
    </div> --}}

    {{-- Table Component --}}
    {{-- <x-ui.table :data="$datas" :columns="$columns" :actions="$actions" :showRowNumber="false"
       :mobileVisibleColumns="2" searchProperty="search" perPageProperty="perPage" :showBulkActions="false"
        emptyMessage="No data found. Create your first data to get started." /> --}}
    <div class="">
        <div class="bg-zinc-500 rounded-2xl p-5">
            <div class="mb-5">
                <h2 class="text-text-white text-2xl font-semibold text-center">{{ __('Order Info') }}</h2>
            </div>
            <div class="flex gap-5">
                <div class="w-full flex gap-5">
                   <div class="w-40 h-40">
                    <img src="{{ asset('assets/images/order/seller.png') }}" alt="" class="w-full h-full object-cover">
                </div>
                    <div class="">
                        <div class="flex gap-5">
                            <p class="text-text-white font-normal textxl">{{ __('Ordder Id: ') }}</p>
                            <p>{{ __('5564531321ZDaSDasdfasfZcxf12sv210') }}</p>
                        </div>
                        <div class="flex gap-5">
                            <p class="text-text-white font-normal textxl">{{ __('Product Name: ') }}</p>
                            <p>{{ __('dasdfasdf') }}</p>
                        </div>
                        <div class="flex gap-5">
                            <p class="text-text-white font-normal textxl">{{ __('Purshase order: ') }}</p>
                            <p>{{ __('dasdfasdf') }}</p>
                        </div>
                        <div class="flex gap-5">
                            <p class="text-text-white font-normal textxl">{{ __('Purshase Date: ') }}</p>
                            <p>{{ __('dasdfasdf') }}</p>
                        </div>
                        <div class="flex gap-5">
                            <p class="text-text-white font-normal textxl">{{ __('Transaction ID: ') }}</p>
                            <p>{{ __('dasdfasdf') }}</p>
                        </div>
                        <div class="flex gap-5">
                            <p class="text-text-white font-normal textxl">{{ __('Transaction ID: ') }}</p>
                            <p>{{ __('dasdfasdf') }}</p>
                        </div>

                    </div>
                </div>
                <div class="w-full flex gap-5">
                    <div class="">
                        <div class="mb-5">
                            <h2 class="text-text-white text-2xl font-semibold text-center">{{ __('Transaction History') }}</h2>
                        </div>
                        <div class="flex gap-5">
                            <p class="text-text-white font-normal textxl">{{ __('Ordder Id: ') }}</p>
                            <p>{{ __('5564531321ZDaSDasdfasfZcxf12sv210') }}</p>
                        </div>
                        <div class="flex gap-5">
                            <p class="text-text-white font-normal textxl">{{ __('Product Name: ') }}</p>
                            <p>{{ __('dasdfasdf') }}</p>
                        </div>
                        <div class="flex gap-5">
                            <p class="text-text-white font-normal textxl">{{ __('Purshase order: ') }}</p>
                            <p>{{ __('dasdfasdf') }}</p>
                        </div>
                        <div class="flex gap-5">
                            <p class="text-text-white font-normal textxl">{{ __('Purshase Date: ') }}</p>
                            <p>{{ __('dasdfasdf') }}</p>
                        </div>
                        <div class="flex gap-5">
                            <p class="text-text-white font-normal textxl">{{ __('Transaction ID: ') }}</p>
                            <p>{{ __('dasdfasdf') }}</p>
                        </div>
                        <div class="flex gap-5">
                            <p class="text-text-white font-normal textxl">{{ __('Transaction ID: ') }}</p>
                            <p>{{ __('dasdfasdf') }}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex gap-5 justify-between">
        <div class="w-full bg-zinc-500 rounded-2xl p-5 mt-10">
            <div class="mb-5">
                <h2 class="text-text-white text-2xl font-semibold text-center">{{ __('Seller Info') }}</h2>
            </div>
            <div class="flex gap-5">
                <div class="w-20 h-20">
                    <img src="{{ asset('assets/images/order/seller.png') }}" alt="" class="w-full h-full object-cover">
                </div>
                <div class="">
                    <div class="flex gap-5">
                        <p class="text-text-white font-normal textxl">{{ __('Ordder Id: ') }}</p>
                        <p>{{ __('5564531321ZDaSDasdfasfZcxf12sv210') }}</p>
                    </div>
                    <div class="flex gap-5">
                        <p class="text-text-white font-normal textxl">{{ __('Product Name: ') }}</p>
                        <p>{{ __('dasdfasdf') }}</p>
                    </div>
                    <div class="flex gap-5">
                        <p class="text-text-white font-normal textxl">{{ __('Purshase order: ') }}</p>
                        <p>{{ __('dasdfasdf') }}</p>
                    </div>
                    <div class="flex gap-5">
                        <p class="text-text-white font-normal textxl">{{ __('Purshase Date: ') }}</p>
                        <p>{{ __('dasdfasdf') }}</p>
                    </div>
                    <div class="flex gap-5">
                        <p class="text-text-white font-normal textxl">{{ __('Transaction ID: ') }}</p>
                        <p>{{ __('dasdfasdf') }}</p>
                    </div>
                    <div class="flex gap-5">
                        <p class="text-text-white font-normal textxl">{{ __('Transaction ID: ') }}</p>
                        <p>{{ __('dasdfasdf') }}</p>
                    </div>

                </div>
            </div>
        </div>
        <div class="w-full bg-zinc-500 rounded-2xl p-5 mt-10">
            <div class="mb-5">
                <h2 class="text-text-white text-2xl font-semibold text-center">{{ __('Seller Info') }}</h2>
            </div>
            <div class="flex gap-5">
                <div class="w-20 h-20">
                    <img src="{{ asset('assets/images/order/seller.png') }}" alt="" class="w-full h-full object-cover">
                </div>
                <div class="">
                    <div class="flex gap-5">
                        <p class="text-text-white font-normal textxl">{{ __('Ordder Id: ') }}</p>
                        <p>{{ __('5564531321ZDaSDasdfasfZcxf12sv210') }}</p>
                    </div>
                    <div class="flex gap-5">
                        <p class="text-text-white font-normal textxl">{{ __('Product Name: ') }}</p>
                        <p>{{ __('dasdfasdf') }}</p>
                    </div>
                    <div class="flex gap-5">
                        <p class="text-text-white font-normal textxl">{{ __('Purshase order: ') }}</p>
                        <p>{{ __('dasdfasdf') }}</p>
                    </div>
                    <div class="flex gap-5">
                        <p class="text-text-white font-normal textxl">{{ __('Purshase Date: ') }}</p>
                        <p>{{ __('dasdfasdf') }}</p>
                    </div>
                    <div class="flex gap-5">
                        <p class="text-text-white font-normal textxl">{{ __('Transaction ID: ') }}</p>
                        <p>{{ __('dasdfasdf') }}</p>
                    </div>
                    <div class="flex gap-5">
                        <p class="text-text-white font-normal textxl">{{ __('Transaction ID: ') }}</p>
                        <p>{{ __('dasdfasdf') }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
