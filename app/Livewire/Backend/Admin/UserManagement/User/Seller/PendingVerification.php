<?php

namespace App\Livewire\Backend\Admin\UserManagement\User\Seller;

use App\Services\SellerProfileService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
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
            // perPage: $this->perPage,
            // filters: $this->getFilters()
        );

      
        // $users = $this->userService->getAllUsers();

        $columns = [
            [
                'key' => 'first_name',
                'label' => 'First Name',
                
            ],
            [
                'key' => 'last_name',
                'label' => 'Last Name',
                
            ], 
            [
                'key' => 'seller_verified',
                'label' => 'status',
                'format'   => function ($data) {
                    return $data->seller_verified ? 'Verified' : 'Unverified';
                }
            ],
            // [
            //     'key' => 'account_status',
            //     'label' => 'Status',
            //     'sortable' => true,
            //     'format' => function ($user) {
            //         return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium '
            //             . $user->account_status_color . '">'
            //             . $user->account_status_label .
            //             '</span>';
            //     }
            // ],
        ];
        $actions = [
            [
                'key' => 'id',
                'label' => 'View Details',
                'route' => 'admin.um.user.seller-verification.view',
                'encrypt' => true,
            ],
            [
                'key' => 'id',
                'label' => 'Make Verified',
                'method' => 'MakeVerified',
                'encrypt' => true,
            ],
        ];
        $bulkActions = [
            
            ['value' => 'verify', 'label' => 'Make Verified'],
        ];

        return view('livewire.backend.admin.user-management.user.seller.pending-verification',[
            'datas' => $datas,
            'columns' => $columns,
            'statuses' => [
                ['value' => '1', 'label' => 'Verified'],
                ['value' => '0', 'label' => 'Unverified'],
            ],
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($userId): void
    {
        $this->deleteUserId = $userId;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        try {
            if (!$this->deleteUserId) {
                return;
            }

            // if ($this->deleteUserId == user()->id) {
            //     $this->error('You cannot delete your own account');
            //     return;
            // }

            $this->service->deleteData($this->deleteUserId);

            $this->showDeleteModal = false;
            $this->deleteUserId = null;

            $this->success('User deleted successfully');
        } catch (\Exception $e) {
            $this->error('Failed to delete User: ' . $e->getMessage());
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }

    public function changeStatus($userId, $status): void
    {
        try {
            $userStatus = UserAccountStatus::from($status);

            match ($userStatus) {
                UserAccountStatus::ACTIVE => $this->service->activateData($userId),
                UserAccountStatus::INACTIVE => $this->service->deactivateData($userId),
                default => null,
            };

            $this->success('User status updated successfully');
        } catch (\Exception $e) {
            $this->error('Failed to update status: ' . $e->getMessage());
        }
    }

    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select Users and an action');
            Log::info('No Users selected or no bulk action selected');
            return;
        }

        $this->showBulkActionModal = true;
    }

    public function executeBulkAction(): void
    {
        $this->showBulkActionModal = false;

      
    }

    protected function bulkDelete(): void
    {
        
    }


    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'account_status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }

    protected function getSelectableIds(): array
    {
        return $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
 
}
