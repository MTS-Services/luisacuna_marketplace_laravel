<?php

namespace App\Livewire\Backend\Admin\UserManagement\User\Seller;

use Livewire\Component;
use App\Services\SellerProfileService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;

class AllSeller extends Component
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

        $datas->load('user');


        // $users = $this->userService->getAllUsers();

        $columns = [
            [
                'key' => 'first_name',
                'label' => 'First Name',
                'format' => function ($data) {
                    $url = route('profile', ['username' => $data->user->username]);
                    $name = $data->user?->full_name;
                    return "<a href='{$url}' target='_blank'>{$name}</a>";
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
                'route' => 'admin.um.user.seller.view',
                'encrypt' => true,
            ],
            [
                'key' => 'user.username',
                'label' => 'View Account',
                'route' => 'profile',
                'target' => '_blank'
            ],
            [
                'key' => 'user_id',
                'label' => 'Feedbacks',
                'route' => 'admin.um.user.feedback',
                'encrypt' => true,
                'format' => function ($data) {
                    return $data->user_id;
                }
            ],
            [
                'key' => 'id',
                'label' => 'Delete',
                'method' => 'confirmDelete'
            ],
        ];
        return view('livewire.backend.admin.user-management.user.seller.all-seller', [
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
            'seller_verified' => 1,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
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
            $this->service->deleteData($this->deleteUserId);

            $this->showDeleteModal = false;
            $this->deleteUserId = null;

            $this->success('User deleted successfully');
        } catch (\Exception $e) {
            $this->error('Failed to delete User: ' . $e->getMessage());
        }
    }
}
