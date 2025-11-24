<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Services\CategoryService;

class Boostings extends Component
{
    protected CategoryService $category_service;

    public function boot(CategoryService $category_service)
    {
        $this->category_service = $category_service;
    }
    public function render()
    {
        // $boostings = $this->category_service->getGamesByCategory('boosting');
        // $popular_boostings = $this->category_service->getGamesByCategoryAndTag('boosting', 'popular');
        // $newly_boostings = $this->category_service->getGamesByCategoryAndTag('boosting', 'newly');


        $allBoostings = $this->category_service->getGamesByCategory('boosting');

        $boostings = $allBoostings;
        $popular_boostings = $allBoostings->filter(function ($game) {
            return $game->tags->contains('slug', 'popular');
        });
        $newly_boostings = $allBoostings->filter(function ($game) {
            return $game->tags->contains('slug', 'newly');
        });


        return view('livewire.frontend.boostings', [
            'boostings' => $boostings,
            'popular_boostings' => $popular_boostings,
            'newly_boostings' => $newly_boostings
        ]);
    }
}
