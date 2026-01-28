<?php

namespace App\Livewire\Backend\Admin\WithdrawalManagement\WithdrawalRequest;

use App\Models\WithdrawalRequest;
use App\Models\WithdrawalStatusHistory;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public function render()
    {
        $datas = WithdrawalRequest::query()
            ->with([
                'user',
                'withdrawalMethod',
                'currentStatusHistory',
            ])
            ->filter([
                'search' => $this->search,
            ])
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $columns = [
            [
                'key' => 'user_id',
                'label' => 'Name',
                'sortable' => true,
                'format' => fn($data) => '
                <div class="flex items-center gap-3">
                    <div class="min-w-0">
                        <h3 class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">'
                    . ($data->user?->full_name ?? '-') .
                    '</h3>
                    </div>
                </div>'
            ],
            [
                'key' => 'withdrawal_method_id',
                'label' => 'Widdrawal Method',
                'sortable' => true,
                'format' => fn($data) => '
                <div class="flex items-center gap-3">
                    <div class="min-w-0">
                        <h3 class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">'
                    . ($data->withdrawalMethod?->name ?? '-') .
                    '</h3>
                    </div>
                </div>'
            ],
            [
                'key' => 'amount',
                'label' => 'Amount',
                'sortable' => true,
                'format' => fn ($data) => '<span class="font-semibold">'.((string) $data->amount).'</span>',
            ],
            [
                'key' => 'fee_amount',
                'label' => 'Fee',
                'sortable' => true,
                'format' => fn ($data) => '<span class="font-semibold">'.((string) $data->fee_amount).'</span>',
            ],
            [
                'key' => 'final_amount',
                'label' => 'Final',
                'sortable' => true,
                'format' => fn ($data) => '<span class="font-semibold">'.((string) $data->final_amount).'</span>',
            ],
            [
                'key' => 'current_status',
                'label' => 'Status',
                'sortable' => false,
                'format' => function ($data) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft ' . ($data->current_status_color ?? 'secondary') . '">' .
                        ($data->current_status_label ?? '-') .
                        '</span>';
                }
            ],
            [
                'key' => 'created_at',
                'label' => 'Created',
                'sortable' => true,
                'format' => fn ($data) => $data->created_at_formatted,
            ],
        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'route' => 'admin.wm.request.view', 'encrypt' => true]
        ];

        return view('livewire.backend.admin.withdrawal-management.withdrawal-request.index', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
        ]);
    }

    public function acceptRequest(int $id): void
    {
        $this->updateStatus($id, 'accepted');
    }

    public function cancelRequest(int $id): void
    {
        $this->updateStatus($id, 'canceled');
    }

    protected function updateStatus(int $id, string $toStatus): void
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
            DB::transaction(function () use ($request, $fromStatus, $toStatus) {
                WithdrawalStatusHistory::create([
                    'withdrawal_request_id' => $request->id,
                    'from_status' => $fromStatus,
                    'to_status' => $toStatus,
                    'changed_by' => admin()?->id,
                    'notes' => null,
                    'metadata' => null,
                ]);
            });

            $this->success('Withdrawal request updated successfully.');
        } catch (\Throwable $throwable) {
            report($throwable);
            $this->error('Failed to update withdrawal request.');
        }
    }
}
