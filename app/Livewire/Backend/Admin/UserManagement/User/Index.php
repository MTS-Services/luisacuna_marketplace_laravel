<?php

namespace App\Livewire\Backend\Admin\UserManagement\User;

use App\Enums\UserAccountStatus;
use App\Enums\UserBanType;
use App\Services\UserService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable, WithNotification;

    protected UserService $service;

    public $statusFilter = '';

    public $deleteUserId;

    public $bulkAction = '';

    public $showDeleteModal = false;

    public $showBulkActionModal = false;

    public $bandUserId;

    public $showBandUserModal = false;

    public string $banReason = '';

    public bool $banPermanent = false;

    public ?string $banDate = null;

    public ?string $banTime = null;

    public $userId;

    public function boot(UserService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $users = $this->service->getPaginateDatas(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        return view('livewire.backend.admin.user-management.user.index', [
            'datas' => $users,
            'columns' => $this->getColumns(),
            'statuses' => UserAccountStatus::options(),
            'actions' => $this->getActions(),
            'bulkActions' => $this->getBulkActions(),

        ]);
    }

    protected function getColumns(): array
    {
        return [
            [
                'key' => 'first_name',
                'label' => 'Name',
                'sortable' => true,
            ],
            [
                'key' => 'username',
                'label' => 'User Name',
                'sortable' => true,
            ],
            [
                'key' => 'email',
                'label' => 'Email',
                'sortable' => true,
            ],
            [
                'key' => 'phone',
                'label' => 'Phone',
                'sortable' => true,
            ],
            [
                'key' => 'account_status',
                'label' => 'Status',
                'sortable' => true,
                'format' => function ($user) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium '
                        .$user->account_status_color.'">'
                        .$user->account_status_label.
                        '</span>';
                },
            ],
        ];
    }

    protected function getActions(): array
    {
        return [
            [
                'key' => 'id',
                'label' => 'Profile',
                'route' => 'admin.um.user.profileInfo',
            ],
            [
                'key' => 'username',
                'label' => 'View Account',
                'route' => 'profile',
                'target' => '_blank',
            ],
            [
                'key' => 'id',
                'label' => 'Wallet Manage',
                'route' => 'admin.um.user.wallet',
            ],
            [
                'key' => 'id',
                'label' => 'Ban History',
                'route' => 'admin.um.user.ban-history',
            ],
            [
                'key' => 'id',
                'label' => 'Feedbacks',
                'encrypt' => true,
                'route' => 'admin.um.user.feedback',
            ],
            [
                'key' => 'id',
                'label' => 'Reward',
                'x_click' => "\$dispatch('point-modal-open', { userId: '{value}' })",
            ],
            [
                'key' => 'id',
                'label' => 'Edit',
                'route' => 'admin.um.user.edit',
            ],
            [
                'key' => 'id',
                'label' => 'Ban User',
                'method' => 'confirmBandUser',
            ],
            [
                'key' => 'id',
                'label' => 'Delete',
                'method' => 'confirmDelete',
            ],
        ];
    }

    protected function getBulkActions(): array
    {
        return [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'deactivate', 'label' => 'Deactivate'],
            ['value' => 'suspend', 'label' => 'Suspend'],
            ['value' => 'bandUser', 'label' => 'Band User'],
        ];
    }

    public function confirmBandUser($userId): void
    {
        $this->bandUserId = $userId;
        $this->showBandUserModal = true;
        $this->banReason = '';
        $this->banPermanent = false;
        $this->banDate = null;
        $this->banTime = null;
    }

    public function bandUser(): void
    {
        try {
            $rules = [
                'banReason' => 'required|string|max:1000',
                'banPermanent' => 'boolean',
            ];

            if (! $this->banPermanent) {
                $rules['banDate'] = 'required|date|after_or_equal:today';
                $rules['banTime'] = 'required|date_format:H:i';
            }

            $this->validate($rules);

            $type = $this->banPermanent ? UserBanType::PERMANENT : UserBanType::TEMPORARY;
            $expiresAt = null;

            if (! $this->banPermanent && $this->banDate && $this->banTime) {
                $expiresAt = Carbon::parse($this->banDate.' '.$this->banTime);
            }

            $this->service->banUser(
                userId: $this->bandUserId,
                reason: $this->banReason,
                type: $type,
                expiresAt: $expiresAt,
            );
            $this->success('User band successfully');

            $this->showBandUserModal = false;
            $this->bandUserId = null;
            $this->banReason = '';
            $this->banPermanent = false;
            $this->banDate = null;
            $this->banTime = null;
        } catch (\Exception $e) {
            $this->error('Failed to band User: '.$e->getMessage());
            $this->showBandUserModal = false;
            $this->bandUserId = null;
            $this->banReason = '';
            $this->banPermanent = false;
            $this->banDate = null;
            $this->banTime = null;
        }
    }

    public function confirmDelete($userId): void
    {
        $this->deleteUserId = $userId;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        try {
            if (! $this->deleteUserId) {
                return;
            }
            $this->service->deleteData($this->deleteUserId);

            $this->showDeleteModal = false;
            $this->deleteUserId = null;

            $this->success('User deleted successfully');
        } catch (\Exception $e) {
            $this->error('Failed to delete User: '.$e->getMessage());
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
            $this->error('Failed to update status: '.$e->getMessage());
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

        try {
            match ($this->bulkAction) {
                'delete' => $this->bulkDelete(),
                'activate' => $this->bulkUpdateStatus(UserAccountStatus::ACTIVE),
                'deactivate' => $this->bulkUpdateStatus(UserAccountStatus::INACTIVE),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->error('Bulk action failed: '.$e->getMessage());
        }
    }

    protected function bulkDelete(): void
    {
        $count = $this->service->bulkDeleteDatas($this->selectedIds);
        $this->success("{$count} Users deleted successfully");
    }

    protected function bulkUpdateStatus(UserAccountStatus $status): void
    {
        $count = $this->service->bulkUpdateStatus($this->selectedIds, $status);
        $this->success("{$count} Users updated successfully");
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'account_status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
            'banned' => false,
            'target_user_id' => $this->userId,
        ];
    }

    protected function getSelectableIds(): array
    {
        return $this->service->getPaginateDatas(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
