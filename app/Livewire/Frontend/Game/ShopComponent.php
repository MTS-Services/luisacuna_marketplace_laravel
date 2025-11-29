<?php

namespace App\Livewire\Frontend\Game;

use Livewire\Component;

class ShopComponent extends Component
{
    public $gameSlug;
    public $categorySlug;
    public $datas = [];
    public $search = '';

    public function tagSelected($tag)
    {
        $this->search = $tag;
        $this->serach(); // Trigger search when tag is selected
    }

    public function mount($gameSlug, $categorySlug)
    {
        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;
        $this->datas = [1, 2, 3, 4, 5, 6, 7];
    }

    public function render()
    {
        return view('livewire.frontend.game.shop-component', [
            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'datas' => $this->datas,
        ]);
    }

    public function serach()
    {
        // Simulate search/fetch logic
        sleep(1);
        
        // Your actual search logic here
        // Example: $this->datas = YourModel::where('name', 'like', '%' . $this->search . '%')->get();
        
        // Dispatch event to stop loading
        $this->dispatch('loaded');
    }

    public function updatedSearch()
    {
        // This method is automatically called when $search property changes
        $this->serach();
    }
}