<?php

namespace App\Livewire\Backend\Admin\WithdrawalManagement\WithdrawalRequest;

use App\Models\WithdrawalRequest;
use App\Models\WithdrawalStatusHistory;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Show extends Component
{
    use WithNotification;

    public bool $showModal = false;

    public WithdrawalRequest $data;

    public ?string $note = null;

    public function mount(WithdrawalRequest $data): void
    {
        $this->data = $data->load([
            'user',
            'withdrawalMethod',
            'currentStatusHistory',
        ]);
    }

    public function render()
    {
        return view('livewire.backend.admin.withdrawal-management.withdrawal-request.show');
    }

    public function openModal(): void
    {
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->note = null;
        $this->data->refresh();
    }

    public function accept(string $encryptedId): void
    {
        $id = decrypt($encryptedId);
        $this->updateStatus($id, 'accepted', null);
    }

    public function reject(string $encryptedId): void
    {
        $id = decrypt($encryptedId);
        $this->updateStatus($id, 'rejected', $this->note);
        $this->showModal = false;
        $this->note = null;
    }

    protected function updateStatus(int $id, string $toStatus, ?string $notes): void
    {
        $request = WithdrawalRequest::query()->with('currentStatusHistory')->find($id);

        if (! $request) {
            $this->error('Withdrawal request not found.');

            return;
        }

        $fromStatus = $request->current_status;

        if ($fromStatus !== 'pending') {
            $this->error('Only pending withdrawal requests can be updated.');

            return;
        }

        try {
            DB::transaction(function () use ($request, $fromStatus, $toStatus, $notes) {
                if ($toStatus === 'rejected') {
                    $request->update([
                        'note' => $notes,
                    ]);
                }

                WithdrawalStatusHistory::create([
                    'withdrawal_request_id' => $request->id,
                    'from_status' => $fromStatus,
                    'to_status' => $toStatus,
                    'changed_by' => admin()?->id,
                    'notes' => $notes,
                    'metadata' => null,
                ]);
            });

            $this->success('Withdrawal request updated successfully.');
            $this->data->refresh();
        } catch (\Throwable $throwable) {
            report($throwable);
            $this->error('Failed to update withdrawal request.');
            Log::error('Error updating withdrawal request: ' . $throwable->getMessage());
        }
    }
}
