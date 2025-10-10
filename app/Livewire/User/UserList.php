<?php

namespace App\Livewire\User;

use App\Actions\User\DeleteUserAction;
use App\Services\User\UserService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination, WithDataTable, WithNotification;

    public string $search = '';
    public int $perPage = 10;
    public string $statusFilter = '';

    protected $listeners = ['userCreated' => '$refresh', 'userUpdated' => '$refresh'];

    public function __construct(
        protected UserService $userService
    ) {}

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function deleteUser(int $userId, DeleteUserAction $action): void
    {
        try {
            $action->execute($userId);

            $this->success('User deleted successfully!');
        } catch (\Exception $e) {
            $this->error('Failed to delete user: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $filters = [];
        if ($this->statusFilter) {
            $filters['status'] = $this->statusFilter;
        }

        $users = $this->search
            ? $this->userService->searchUsers($this->search, $this->perPage)
            : $this->userService->getPaginatedUsers($this->perPage, $filters);

        return view('livewire.user.user-list', [
            'users' => $users,
        ]);
    }
}
