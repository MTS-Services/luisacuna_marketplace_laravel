<?php

namespace App\Livewire\Backend\User\Profile;

use App\Enums\FeedbackType;
use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;

class UserProfilePage extends Component
{
    public User $user;

    #[Url(keep: true)]
    public string $tab = 'shop';

    public int $positiveFeedbacksCount = 0;

    public int $negativeFeedbacksCount = 0;

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->positiveFeedbacksCount = $this->user->feedbacksReceived()
            ->where('type', FeedbackType::POSITIVE->value)
            ->count();
        $this->negativeFeedbacksCount = $this->user->feedbacksReceived()
            ->where('type', FeedbackType::NEGATIVE->value)
            ->count();
    }

    public function render()
    {
        return view('livewire.backend.user.profile.user-profile-page');
    }
}
