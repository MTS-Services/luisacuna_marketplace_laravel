{{-- <div x-data="{
    orderDetailModalShow: @entangle('orderDetailModalShow').live
}"
    @order-detail-modal-open.window="orderDetailModalShow = true; console.log('open order detail');"
    x-show="orderDetailModalShow" class="fixed inset-0 bg-black/5 backdrop-blur-md z-20 flex items-center justify-center">




    <div class="bg-main rounded-2xl p-10 max-w-7xl w-full">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-5">
            <h2 class="text-text-white text-2xl font-semibold text-center">{{ __('Order Detail') }}</h2>
            <button wire:click="closeModal" class="text-text-muted hover:text-text-primary">
                <x-phosphor name="x" variant="regular" class="w-6 h-6" />
            </button>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <div class="mb-5">
                <h2 class="text-text-white text-2xl font-semibold text-center">{{ __('') }}</h2>
            </div>
            <div class="flex gap-5">
                <div class="w-full flex gap-5">
                    <div class="w-40 h-40">
                        <img src="{{ asset('assets/images/order/seller.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <div class="">
                        <div class="mb-5">
                            <h2 class="text-text-white text-2xl font-semibold text-center">
                                {{ __('Order Info') }}</h2>
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
                <div class="w-full flex gap-5">
                    <div class="">
                        <div class="mb-5">
                            <h2 class="text-text-white text-2xl font-semibold text-center">
                                {{ __('Transaction History') }}</h2>
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
                    <div class="w-full">
                        <div class="mb-5">
                            <h2 class="text-text-white text-2xl font-semibold text-center">
                                {{ __('Transaction History') }}
                            </h2>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full border border-zinc-800 rounded-xl overflow-hidden">
                                <thead class="bg-white/5">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-text-white font-semibold">
                                            {{ __('Sl') }}
                                        </th>
                                        <th class="px-4 py-3 text-left text-text-white font-semibold">
                                            {{ __('Transaction Id') }}
                                        </th>
                                        <th class="px-4 py-3 text-left text-text-white font-semibold">
                                            {{ __('Amount') }}
                                        </th>
                                        <th class="px-4 py-3 text-left text-text-white font-semibold">
                                            {{ __('Date') }}
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="border-t border-zinc-800">
                                        <td class="px-4 py-3 text-text-white">
                                            01
                                        </td>
                                        <td class="px-4 py-3 text-text-white">
                                            OrderId312351212
                                        </td>
                                        <td class="px-4 py-3 text-text-white">
                                            100$
                                        </td>
                                        <td class="px-4 py-3 text-text-white">
                                            12-12-25
                                        </td>

                                    </tr>
                                    <tr class="border-t border-zinc-800">
                                        <td class="px-4 py-3 text-text-white">
                                            01
                                        </td>
                                        <td class="px-4 py-3 text-text-white">
                                            OrderId312351212
                                        </td>
                                        <td class="px-4 py-3 text-text-white">
                                            100$
                                        </td>
                                        <td class="px-4 py-3 text-text-white">
                                            12-12-25
                                        </td>

                                    </tr>
                                    <tr class="border-t border-zinc-800">
                                        <td class="px-4 py-3 text-text-white">
                                            01
                                        </td>
                                        <td class="px-4 py-3 text-text-white">
                                            OrderId312351212
                                        </td>
                                        <td class="px-4 py-3 text-text-white">
                                            100$
                                        </td>
                                        <td class="px-4 py-3 text-text-white">
                                            12-12-25
                                        </td>

                                    </tr>
                                    <tr class="border-t border-zinc-800">
                                        <td class="px-4 py-3 text-text-white">
                                            01
                                        </td>
                                        <td class="px-4 py-3 text-text-white">
                                            OrderId312351212
                                        </td>
                                        <td class="px-4 py-3 text-text-white">
                                            100$
                                        </td>
                                        <td class="px-4 py-3 text-text-white">
                                            12-12-25
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-10">
            <div class="glass-card w-full p-5">
                <div class="mb-5">
                    <h2 class="text-text-white text-2xl font-semibold text-center">{{ __('Seller Info') }}</h2>
                </div>
                <div class="flex gap-5">
                    <div class="w-20 h-20">
                        <img src="{{ asset('assets/images/order/seller.png') }}" alt=""
                            class="w-full h-full object-cover">
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
            <div class="glass-card w-full p-5">
                <div class="mb-5">
                    <h2 class="text-text-white text-2xl font-semibold text-center">{{ __('Buyer Info') }}</h2>
                </div>
                <div class="flex gap-5">
                    <div class="w-20 h-20">
                        <img src="{{ asset('assets/images/order/seller.png') }}" alt=""
                            class="w-full h-full object-cover">
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
    </div>

</div> --}}


<div x-data="{ orderDetailModalShow: @entangle('orderDetailModalShow').live }"
    @order-detail-modal-open.window="orderDetailModalShow = true; console.log('open order detail');"
    x-show="orderDetailModalShow" class="fixed inset-0 bg-black/5 backdrop-blur-md z-20 flex items-center justify-center"
    x-cloak>

    <div class="bg-main rounded-3xl p-3 sm:p-6 md:p-10 max-w-7xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-zinc-800"
        @click.away="orderDetailModalShow = false">

        <div class="flex items-center justify-between mb-8 border-b border-zinc-800 pb-5">
            <div>
                <h2 class="text-text-white text-2xl md:text-3xl font-bold tracking-tight">{{ __('Order Detail') }}</h2>
                <p class="text-text-muted text-sm mt-1">Review all information regarding this transaction</p>
            </div>
            <button wire:click="closeModal" @click="orderDetailModalShow = false"
                class="text-text-muted hover:text-text-primary">
                <x-phosphor name="x" variant="regular" class="w-6 h-6 text-text-white" />
            </button>
        </div>

        <div class="glass-card rounded-2xl p-2 sm:p-6 md:p-8 bg-white/5 border border-zinc-800">
            <div class="flex flex-col lg:flex-row gap-8">

                <div class="flex-1 flex flex-col md:flex-row gap-4 sm:gap-6">
                    <div class="w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 flex-shrink-0 mx-auto md:mx-0">
                        <img src="{{ asset('assets/images/order/seller.png') }}" alt="Product"
                            class="w-full h-full object-cover rounded-full border border-zinc-800 shadow-lg">
                    </div>

                    <div class="flex-1 space-y-4">
                        <h3
                            class="text-text-white text-xl font-semibold mb-4 border-l-4 border-zinc-700 pl-3 leading-none">
                            {{ __('Order Info') }}
                        </h3>

                        <div class="grid grid-cols-1 gap-y-3">
                            <div class="flex justify-between items-start border-b border-zinc-800 pb-2">
                                <span class="text-text-muted text-sm">{{ __('Order ID') }}</span>
                                <span
                                    class="text-text-white font-medium text-right break-all ml-4 text-sm uppercase">{{ $order->order_id }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-zinc-800 pb-2">
                                <span class="text-text-muted text-sm">{{ __('Product') }}</span>
                                <span class="text-text-white font-medium">Premium Product Name</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-zinc-800 pb-2">
                                <span class="text-text-muted text-sm">{{ __('Purchase Date') }}</span>
                                <span class="text-text-white font-medium">Oct 24, 2023</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-text-muted text-sm">{{ __('Total Amount') }}</span>
                                <span class="text-zinc-500 font-bold text-lg">$1,200.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-1">
                    <h3
                        class="text-text-white text-xl font-semibold mb-4 border-l-4 border-zinc-800 pl-3 leading-none">
                        {{ __('Transaction History') }}
                    </h3>
                    <div class="overflow-hidden border border-zinc-800 rounded-xl bg-main">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-card text-text-white uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3 font-semibold">{{ __('ID') }}</th>
                                    <th class="px-4 py-3 font-semibold">{{ __('Amount') }}</th>
                                    <th class="px-4 py-3 font-semibold text-right">{{ __('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach (range(1, 3) as $item)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-1 sm:px-4 py-1 sm:py-3 text-text-muted">#TXN-99{{ $item }}</td>
                                        <td class="px-1 sm:px-4 py-1 sm:py-3 text-text-white font-medium">$400.00</td>
                                        <td class="px-1 sm:px-4 py-1 sm:py-3 text-text-muted text-right italic text-xs">12-12-2025</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div
                class="glass-card p-6 bg-main border border-zinc-800 rounded-2xl">
                <h3 class="text-text-white text-lg font-semibold mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 bg-zinc-500 rounded-full"></span>
                    {{ __('Seller Details') }}
                </h3>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/order/seller.png') }}"
                        class="w-16 h-16 rounded-full ring-2 ring-white/10 object-cover">
                    <div class="space-y-1">
                        <p class="text-text-white font-bold">John Doe Store</p>
                        <p class="text-text-muted text-xs">Verified Seller</p>
                        <p class="text-text-muted text-xs break-all">seller@example.com</p>
                    </div>
                </div>
            </div>

            <div
                class="glass-card p-6 bg-main border border-zinc-800 rounded-2xl">
                <h3 class="text-text-white text-lg font-semibold mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 bg-zinc-500 rounded-full"></span>
                    {{ __('Buyer Details') }}
                </h3>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/order/seller.png') }}"
                        class="w-16 h-16 rounded-full ring-2 ring-white/10 object-cover">
                    <div class="space-y-1">
                        <p class="text-text-white font-bold">Alex Smith</p>
                        <p class="text-text-muted text-xs">Customer since 2022</p>
                        <p class="text-text-muted text-xs">New York, USA</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
