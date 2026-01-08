<?php

namespace App\Livewire\Backend\User\Profile;

use App\Models\User;
use Livewire\Component;
use App\Enums\FeedbackType;
use Livewire\Attributes\Url;
use App\Services\FeedbackService;
use App\Traits\WithPaginationData;
use Illuminate\Database\Eloquent\Collection;

class Review extends Component
{
    public User $user;
    use WithPaginationData;


    #[Url(keep: true)]
    public string $type = 'all';
    public $reviewItem = null;

    protected FeedbackService $service;

    public function boot(FeedbackService $service)
    {
        $this->service = $service;
    }

    public function mount(User $user)
    {
        $this->user = $user;
    }
    public function switchReviewItem($type)
    {
        $this->type = $type;
    }
    public function render()
    {
        $feedbacks = $this->service->getPaginatedData(
            perPage: 10,
            filters: $this->getFilters()
        );

        $this->paginationData($feedbacks);
        return view('livewire.backend.user.profile.review', [
            'feedbacks' => $feedbacks
        ]);
    }

    protected function getFilters(): array
    {
        return [
            'target_user_id' => $this->user->id,
            'type' => $this->typeMatch($this->type),
        ];
    }

    protected function typeMatch($type)
    {
        return match ($type) {
            'all' => null,
            'positive' => FeedbackType::POSITIVE,
            'negative' => FeedbackType::NEGATIVE,
        };
    }
}
