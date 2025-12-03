<?php

namespace App\Livewire\Backend\User\Offers;

use App\Services\CategoryService;
use App\Services\GameService;
use Livewire\Component;

class Offer extends Component
{
    public $step = 1;
    public $selectedCategory = null;
    public $selectedCategoryId = null;
    public $categoryGames = [];
    public $selectedGame = null;
    public $selectedGameData = null;
    
    // Dynamic configuration fields
    public $gameConfigs = [];
    public $configValues = [];

    protected CategoryService $categoryService;
    protected GameService $gameService;

    public function boot(CategoryService $categoryService, GameService $gameService)
    {
        $this->categoryService = $categoryService;
        $this->gameService = $gameService;
    }

    public function selectCategory($categoryId, $categoryName)
    {
        $this->selectedCategoryId = $categoryId;
        $this->selectedCategory = $categoryName;

        $category = $this->categoryService->findData($categoryId);
        $this->categoryGames = $category->games ?? [];

        $this->step = 2;
    }

    public function updatedSelectedGame($gameId)
    {
        // Reset previous selections
        $this->configValues = [];
        if ($gameId) {

            $game = $this->gameService->findData($gameId);

            $game->load('gameConfig');

           $this->gameConfigs = $game->gameConfig;

            $this->selectedGameData = $game;
            
        } else {
            $this->selectedGameData = null;
            $this->gameConfigs = [];
        }
    }

    public function selectGame()
    {
        $this->validate([
            'selectedGame' => 'required',
        ]);

        $this->step = 3;
    }

    public function submitOffer()
    {
        // Dynamic validation rules based on game configs
        $rules = [
            'selectedGame' => 'required',
        ];
        
        foreach ($this->gameConfigs as $config) {
            $rules['configValues.' . $config->slug] = 'required';
        }
        
        $this->validate($rules);


        session()->flash('message', 'Offer successfully created!');
        $this->reset();
    }

    public function back()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function render()
    {
        $categories = $this->categoryService->getDatas();
        return view('livewire.backend.user.offers.offer', [
            'categories' => $categories
        ]);
    }
}