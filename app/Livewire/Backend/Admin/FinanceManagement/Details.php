<?php

namespace App\Livewire\Backend\Admin\FinanceManagement;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\TransactionService;

class Details extends Component
{
    public bool $isLoading = true;
    public bool $transactionDetailModalShow = false;
    // public Order $order;
    public $transaction;


    protected TransactionService $Service;

    public function boot(TransactionService $Service)
    {
        $this->Service = $Service;
    }
    // public function boot()
    // {
    //     $this->order = new Order();
    // }
    public function closeModal()
    {
        $this->transactionDetailModalShow = false;
    }
    public function render()
    {
        return view('livewire.backend.admin.finance-management.details');
    }

    #[On('transaction-detail-modal-open')]
    public function fetchOrderDetail($transactionId)
    {
        $this->isLoading = true;
        $this->transaction = $this->Service->findData($transactionId, 'transaction_id');

        // $this->order->load(['user', 'source.user', 'source.game', 'transactions']);

        $this->transactionDetailModalShow = true;
        $this->isLoading = false;
    }
}
