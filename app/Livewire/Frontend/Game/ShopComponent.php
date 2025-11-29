<?php

namespace App\Livewire\Frontend\Game;

use Livewire\Component;

class ShopComponent extends Component
{
    public $gameSlug;
    public $categorySlug;
    public $datas = [];
    public $search = '';
    public $selectedDevice = null;
    public $selectedAccountType = null;
    public $selectedPrice = null;
    public $selectedDeliveryTime = null;
    public $layoutView = 'list';
    

    public function tagSelected($tag)
    {
        $this->search = $tag;
        $this->serachFilter(); // Trigger search when tag is selected
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

    public function serachFilter()
    {
        // Simulate search/fetch logic
        sleep(1);
        
        // Your actual search logic here
        // Example: $this->datas = YourModel::where('name', 'like', '%' . $this->search . '%')->get();
        
        // Dispatch event to stop loading
        $this->dispatch('loaded');
    }

    public function resetAllFilters()
    {
        $this->search = '';
        $this->selectedDevice = null;
        $this->selectedAccountType = null;
        $this->selectedPrice = null;
        $this->selectedDeliveryTime = null;
        
        $this->serachFilter(); // Trigger search to reset filters
    }   

    public function changeView()
    {
        // Logic to change view layout
        $this->layoutView = $this->layoutView === 'grid' ? 'list' : 'grid';
    }

}