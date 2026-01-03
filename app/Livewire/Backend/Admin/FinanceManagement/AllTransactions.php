<?php

namespace App\Livewire\Backend\Admin\FinanceManagement;

use Livewire\Component;
use App\Services\TransactionService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;

class AllTransactions extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteCategoryId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;
    public $deleteId = null;

    protected TransactionService $service;

    public function boot(TransactionService $service)
    {
        $this->service = $service;
    }
    public function render()
    {
        $datas = $this->service->paginateDatas(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );


        $columns = [
            [
                'key' => 'transaction_id',
                'label' => 'Transaction ID',
                'sortable' => true,
            ],
            [
                'key' => 'user_id',
                'label' => 'User',
                'sortable' => true,
                'format' => fn($data) => '<a href="' . route('profile', ['username' => $data->user->username]) . '" target="_blank"><span class="text-zinc-500 text-xs xxs:text-sm md:text-base truncate">' . $data->user->full_name . '</span></a>'
            ],
            [
                'key' => 'amount',
                'label' => 'Price ($)',
                'sortable' => true,
                'format' => fn($data) => '<span class="font-semibold ' . $data->calculation_type->textColor() . ' ">' . $data->calculation_type->prefix() . ' ' . $data->net_amount ?? 0 . '</span>'
            ],
            [
                'key' => 'payment_gateway',
                'label' => 'Payment Method',
                'sortable' => true,
                'format' => fn($data) => $data->payment_gateway,
            ],
            [
                'key' => 'created_at',
                'label' => 'Created',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->created_at_formatted;
                }
            ],
        ];
        $actions = [
            [
                'key' => 'transaction_id',
                'label' => 'View',
                'x_click' => "\$dispatch('transaction-detail-modal-open', { transactionId: '{value}' }); console.log('open');",

            ],
        ];
        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],

        ];
        return view('livewire.backend.admin.finance-management.all-transactions', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }

    protected function getFilters(): array
    {
        return [
            // 'status'         => $this->statusFilter,
            'sort_field'     => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }


    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
