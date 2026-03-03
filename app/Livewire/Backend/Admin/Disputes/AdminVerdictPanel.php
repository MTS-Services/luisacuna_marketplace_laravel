<?php

namespace App\Livewire\Backend\Admin\Disputes;

use App\Actions\Dispute\ResolveDisputeAction;
use App\Enums\DisputeStatus;
use App\Models\Dispute;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminVerdictPanel extends Component
{
    public Dispute $dispute;

    public string $note = '';

    protected ResolveDisputeAction $resolveDisputeAction;

    public function boot(ResolveDisputeAction $resolveDisputeAction): void
    {
        $this->resolveDisputeAction = $resolveDisputeAction;
    }

    public function mount(int $disputeId): void
    {
        if (! Auth::guard('admin')->check()) {
            abort(403);
        }

        $this->dispute = Dispute::query()
            ->with(['order', 'buyer', 'vendor', 'attachments', 'messages.sender'])
            ->findOrFail($disputeId);
    }

    protected function rules(): array
    {
        return [
            'note' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function issueRefund(): void
    {
        $this->resolve(DisputeStatus::RESOLVED_REFUND);
    }

    public function releasePayment(): void
    {
        $this->resolve(DisputeStatus::RESOLVED_CLOSED);
    }

    protected function resolve(DisputeStatus $status): void
    {
        $this->validate();

        $updated = $this->resolveDisputeAction->execute(
            dispute: $this->dispute,
            status: $status,
            adminNote: $this->note ?: null,
        );

        $this->dispute = $updated;

        session()->flash('success', __('Dispute updated successfully.'));
    }

    public function render()
    {
        return view('livewire.backend.admin.disputes.admin-verdict-panel');
    }
}

