<?php

namespace App\Livewire\Backend\User\Wallet;

use App\Enums\CalculationType;
use App\Models\Wallet as ModelWallet;
use App\Services\TransactionService;
use Livewire\Component;
use Livewire\WithPagination;

class Wallet extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';
    public ?ModelWallet $wallet = null;

    protected TransactionService $transactionService;

    public function boot(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
        $this->wallet = user()->load('wallet')->wallet;
    }

    public function render()
    {
        $datas = $this->transactionService->paginateDatas(
            perPage: $this->perPage,
            filters: $this->filter()
        );
        $datas->load(['order', 'source']);
        // Table columns configuration
        $columns = [
            [
                'key' => 'created_at',
                'label' => 'Date Created',
                'format' => fn($item) => $item->created_at_formatted
            ],
            [
                'key' => 'net_amount',
                'label' => 'Balance',
                'format' => fn($item) =>
                '<span class="font-semibold ' . $item->calculation_type->textColor() . ' ">' . $item->calculation_type->prefix() . ' ' . currency_exchange($item->net_amount ?? 0) . '</span>'
            ],
            [
                'key' => 'order_id',
                'label' => 'Order ID',
                'format' => fn($item) => $item->order?->order_id ?? ' - '
            ],
            [
                'key' => 'notes',
                'label' => 'Description',
                'format' => fn($item) =>
                '<span class="line-clamp-2">' . $item->notes . '</span>'
            ],
            [
                'key' => 'action',
                'label' => 'Action',
                'format' => fn($item) => '
                    <div class="flex items-center gap-3">
                    <a href="#"  class="bg-zinc-500 hover:bg-zinc-600 text-white py-2 px-4 rounded-full">View</a>
                    </div>'
            ],
        ];

        return view('livewire.backend.user.wallet.wallet', [
            'datas' => $datas,
            'columns' => $columns,
            // 'pagination' => $pagination,
        ]);
    }

    public function filter()
    {
        return [
            'search' => $this->search,
            'user_id' => user()->id,
            'sort_field' => 'created_at',
            'sort_direction' => 'desc',
        ];
    }


    public function pauseItem($id)
    {
        //  pause logic 
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Item #{$id} paused successfully"
        ]);
    }

    public function resumeItem($id)
    {
        // resume logic 
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Item #{$id} resumed successfully"
        ]);
    }
}
