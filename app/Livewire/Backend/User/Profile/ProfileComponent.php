<?php

namespace App\Livewire\Backend\User\Profile;

use App\Models\User;
use Livewire\Component;
use App\Enums\FeedbackType;

class ProfileComponent extends Component
{
    public $user;
    public $positiveFeedbacksCount;
    public $negativeFeedbacksCount;

    public function mount(User $user)
    {
        $this->user = $user;
        $allFeedbacks = $this->user?->user?->feedbacksReceived()->get();
        $this->positiveFeedbacksCount = $this->user?->user?->feedbacksReceived()->where('type', FeedbackType::POSITIVE->value)->count();
        $this->negativeFeedbacksCount = $this->user?->user?->feedbacksReceived()->where('type', FeedbackType::NEGATIVE->value)->count();
    }

    public function render()
    {
        return view('livewire.backend.user.profile.profile-component');
    }
}
