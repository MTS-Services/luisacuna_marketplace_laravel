<?php

namespace App\Livewire\Backend\User\Feedback;

use Livewire\Component;
use Livewire\Attributes\Url;

class FeedbackComponent extends Component
{
    #[Url(as: 'type')]
    public $activeTab = 'all';

    // ✅ Tab change method
    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function getFilteredFeedbacks()
    {
        $feedbacks = $this->getAllFeedbacks();

        if ($this->activeTab === 'positive') {
            return collect($feedbacks)->where('type', 'positive')->values();
        } elseif ($this->activeTab === 'negative') {
            return collect($feedbacks)->where('type', 'negative')->values();
        }

        return collect($feedbacks);
    }

    private function getAllFeedbacks()
    {
        return [
            [
                'id' => 1,
                'type' => 'positive',
                'category' => 'Items',
                'username' => 'Yes***',
                'comment' => 'Yes***',
                'date' => '24.10.25'
            ],
            [
                'id' => 2,
                'type' => 'positive',
                'category' => 'Items',
                'username' => 'Yes***',
                'comment' => 'Yes***',
                'date' => '24.10.25'
            ],
            [
                'id' => 3,
                'type' => 'positive',
                'category' => 'Items',
                'username' => 'Yes***',
                'comment' => 'Yes***',
                'date' => '24.10.25'
            ],
            [
                'id' => 4,
                'type' => 'positive',
                'category' => 'Items',
                'username' => 'Yes***',
                'comment' => 'Yes***',
                'date' => '24.10.25'
            ],
            [
                'id' => 5,
                'type' => 'negative',
                'category' => 'Items',
                'username' => 'Yes***',
                'comment' => 'Did not respond in over 24 hours to the messages, even though "average delivery time" is 3 hours, and being online on Fortnite. Was friended for over 48 hours and did not send the gift nor reply to the messages.',
                'date' => '24.10.25'
            ],
        ];
    }

    public function render()
    {
        return view('livewire.backend.user.feedback.feedback-component', [
            'feedbacks' => $this->getFilteredFeedbacks(),
            'activeTab' => $this->activeTab
        ]);
    }
}