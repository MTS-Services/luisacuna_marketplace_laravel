<?php

namespace App\Livewire\Backend\Admin\UserManagement\User;

use App\Models\User;
use Livewire\Component;
use App\Enums\PointType;
use App\Models\PointLog;
use App\Models\UserPoint;
use Livewire\Attributes\On;
use App\Services\UserService;
use App\Traits\Livewire\WithNotification;

class Reward extends Component
{

    use WithNotification;

    public bool $isLoading = false;
    public bool $pointModalShow = false;

    public $user_id;
    public $type;
    public $points;
    public $notes;
    public $users;

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'points' => 'required|integer|min:1',
        'type' => 'required|string',
        'notes' => 'required|string|max:500',
    ];

    public function mount()
    {
        $this->users = User::select('id', 'first_name', 'last_name', 'username')->get();
    }

    #[On('point-modal-open')]
    public function openModal($userId = null)
    {
        $this->user_id = $userId;
        $this->pointModalShow = true;
        
    }

    public function submitPoints()
    {
        $this->validate();

        $this->isLoading = true;

        try {
            $user = User::findOrFail($this->user_id);

            $pointLog = PointLog::create([
                'user_id' => $user->id,
                'source_id' => $user->id,
                'source_type' => User::class,
                'type' => $this->type,
                'points' => $this->points,
                'notes' => $this->notes,
            ]);

            $userPoint = UserPoint::firstOrNew(['user_id' => $user->id]);
            $userPoint->points += $pointLog->points;
            $userPoint->save();



            $this->reset(['user_id', 'type', 'points', 'notes']);
            $this->closeModal();

            $this->success('User points updated successfully');
        } catch (\Exception $e) {
            session()->flash('error', __('Failed to update points. Please try again.'));
        } finally {
            $this->isLoading = false;
        }
    }

    public function closeModal()
    {
        $this->pointModalShow = false;
        $this->reset(['user_id', 'type', 'points', 'notes']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.backend.admin.user-management.user.reward', [
            'types' => PointType::options(),
        ]);
    }
}
