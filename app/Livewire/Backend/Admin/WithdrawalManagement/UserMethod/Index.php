<?php

namespace App\Livewire\Backend\Admin\WithdrawalManagement\UserMethod;

use Livewire\Component;
use App\Models\UserWithdrawalAccount;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use App\Services\UserWithdrawalAccountService;

class Index extends Component
{
    use WithDataTable, WithNotification;


    protected UserWithdrawalAccountService $service;

    public UserWithdrawalAccount $data;

    public function boot(UserWithdrawalAccountService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getAllDatas(
            sortField: $this->sortField,
            order: $this->sortDirection
        );

        $columns = [
            [
                'key' => 'user_id',
                'label' => 'Name',
                'sortable' => true,
                'format' => fn($data) => '
                <div class="flex items-center gap-3">
                    <div class="min-w-0">
                        <h3 class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">'
                    . $data->user?->full_name .
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
                    . $data->withdrawalMethod?->name .
                    '</h3>
                    </div>
                </div>'
            ],
            [
                'key' => 'account_name',
                'label' => 'Account Name',
                'sortable' => true,

            ],
            [
                'key' => 'status',
                'label' => 'Status',
                'sortable' => true,
                'format' => function ($data) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft ' . $data->status->color() . '">' .
                        $data->status->label() .
                        '</span>';
                }
            ],
            [
                'key' => 'created_at',
                'label' => 'Created Date',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->created_at_formatted;
                }
            ],
        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'route' => 'admin.wm.user-method.view', 'encrypt' => true],
        ];

        return view('livewire.backend.admin.withdrawal-management.user-method.index', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
        ]);
    }
    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }

    // protected function getSelectableIds(): array
    // {
    //     $data = $this->service->getPaginatedData(
    //         perPage: 12,
    //         filters: $this->getFilters()
    //     );

    //     return array_column($data->items(), 'id');
    // }
}
