<?php

namespace App\Livewire\Backend\Admin\UserManagement\User\Seller;

use App\Services\SellerProfileService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class PendingVerification extends Component
{
    use WithDataTable, WithNotification;


    protected SellerProfileService $service;

    public $statusFilter = '';
    public $deleteUserId;
    public $bulkAction = '';
    public $showDeleteModal = false;
    public $showBulkActionModal = false;

    public function boot(SellerProfileService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );


        // $users = $this->userService->getAllUsers();

        $columns = [
            [
                'key' => 'first_name',
                'label' => 'First Name',
                'format'   => function ($data) {
                    return $data->first_name ?? $data->company_name ?? $data->user->first_name;
                }

            ],
            [
                'key' => 'seller_verified',
                'label' => 'status',
                'format'   => function ($data) {
                    return $data->seller_verified ? 'Verified' : 'Unverified';
                }
            ],
            [
                'key' => 'created_at',
                'label' => 'Submitted At',
                'sortable' => true,
                'format'   => function ($data) {
                    return $data->user->created_at_formatted;
                }

            ],
        ];
        $actions = [
            [
                'key' => 'id',
                'label' => 'View Details',
                'route' => 'admin.um.user.seller-verification.view',
                'encrypt' => true,
            ],
        ];
        return view('livewire.backend.admin.user-management.user.seller.pending-verification', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
        ]);
    }


    // Not mine

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }


    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'seller_verified' => 0,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }

}
