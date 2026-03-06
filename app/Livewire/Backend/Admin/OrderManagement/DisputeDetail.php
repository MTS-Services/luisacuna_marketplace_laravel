<?php

namespace App\Livewire\Backend\Admin\OrderManagement;

use App\Models\Dispute;
use App\Models\Order;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class DisputeDetail extends Component
{
    use WithNotification;

    public Order $data;

    public ?Dispute $dispute = null;

    public ?string $backUrl = null;

    public ?string $conversationUrl = null;

    public function mount(Order $data): void
    {
        $this->data = $data;
        $this->data->load([
            'user',
            'source.user',
            'source.game',
            'transactions',
            'feedbacks.author',
            'conversation',
            'disputes',
        ]);

        $this->dispute = Dispute::query()
            ->where('order_id', $this->data->id)
            ->latest('id')
            ->with(['order', 'buyer', 'vendor', 'attachments', 'messages.sender'])
            ->first();

        if ($this->data->conversation?->conversation_uuid) {
            $this->conversationUrl = route('admin.conversation.index', [
                'conversation' => $this->data->conversation->conversation_uuid,
            ]);
        }

        $this->backUrl = url()->previous() !== url()->current()
            ? url()->previous()
            : route('admin.orders.dispute-orders');
    }

    public function render()
    {
        return view('livewire.backend.admin.order-management.dispute-detail');
    }
}
