<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Services\CategoryService;

class Items extends Component
{

    public $activeTab = 'giftCard';


    protected CategoryService $category_service;

    public function boot(CategoryService $category_service)
    {
        $this->category_service = $category_service;
    }
    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function render()
    {

        // $items = $this->category_service->getGamesByCategory('items');
        // $popular_items = $this->category_service->getGamesByCategoryAndTag('items', 'popular');

        $allItems = $this->category_service->getGamesByCategory('items');
        $items = $allItems;
        $popular_items = $allItems->filter(function ($game) {
            return $game->tags->contains('slug', 'popular');
        });


        return view('livewire.frontend.items', [
            'items' => $items,
            'popular_items' => $popular_items
        ]);
    }
}
