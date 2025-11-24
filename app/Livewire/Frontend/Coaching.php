<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Services\CategoryService;

class Coaching extends Component
{
    protected CategoryService $category_service;

    public function boot(CategoryService $category_service)
    {
        $this->category_service = $category_service;
    }
    public function render()
    {
        // $coachings = $this->category_service->getGamesByCategory('coaching');
        // $popular_coachings = $this->category_service->getGamesByCategoryAndTag('coaching', 'popular');
        // $newly_coachings = $this->category_service->getGamesByCategoryAndTag('coaching', 'newly');

        $allCoachings = $this->category_service->getGamesByCategory('coaching');

        $coachings = $allCoachings;
        $popular_coachings = $allCoachings->filter(function ($game) {
            return $game->tags->contains('slug', 'popular');
        });
        $newly_coachings = $allCoachings->filter(function ($game) {
            return $game->tags->contains('slug', 'newly');
        });


        return view('livewire.frontend.coaching', [
            'coachings' => $coachings,
            'popular_coachings' => $popular_coachings,
            'newly_coachings' => $newly_coachings
        ]);
    }
}
