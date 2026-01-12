<?php

namespace App\Livewire\Backend\Admin\OrderManagement;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\ConversationService;
use App\Services\NotificationService;
use App\Services\OrderService;
use Livewire\Component;
use Illuminate\Support\Facades\URL;

class Detail extends Component
{
    public Order $data;
    public ?string $backUrl = null;

    public $showDisputeModal = false;

    public $reason; 

    public $disputeType;

    protected OrderService $service;
    
    public function boot(OrderService $service) {
        $this->service = $service;
    }
    public function mount(Order $data): void
    {
        $this->data = $data;
        $this->data->load(['user', 'source.user', 'source.game', 'transactions']);

        // Capture previous URL, fallback to the default route if no referrer exists
        $this->backUrl = url()->previous() !== url()->current()
            ? url()->previous()
            : route('admin.orders.index');
    }

    public function render()
    {
        return view('livewire.backend.admin.order-management.detail');
    }

    public function acceptDispute()
    {
        $this->showDisputeModal = true;
        $this->disputeType = 'accept';
    }

    public function rejectDispute()
    {
        $this->showDisputeModal = true;
        $this->disputeType = 'reject';
    }
    
    public function submitDispute()
    {
        $this->validate([
            'reason' => 'required|string|min:10',
        ]);

        $this->service->disputeResolution($this->data->id, $this->disputeType, $this->reason);


        $this->data->refresh();
        $this->showDisputeModal = false;

        $this->reset('reason', 'disputeType');
        
        session()->flash('message', 'Dispute has been processed successfully.');
        
        $this->redirect(URL::previous());

        $this->info('Dispute has been processed successfully.');
    }
}