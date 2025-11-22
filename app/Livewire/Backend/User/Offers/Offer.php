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
    public $selectedGameData = null; // Game এর full data with relations
    
    // Dynamic relational data
    public $servers = [];
    public $factions = [];
    public $deliveryMethods = [];
    
    // Selected values
    public $selectedServer = null;
    public $selectedFaction = null;
    public $selectedDeliveryMethod = null;


    protected CategoryService $categoryService;
    protected GameService $gameService;

    public function boot(CategoryService $categoryService, GameService $gameService)
    {
        $this->categoryService = $categoryService;
        $this->gameService = $gameService;
    }

    // Category select korar function
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
        $this->selectedServer = null;
        $this->selectedFaction = null;
        $this->selectedDeliveryMethod = null;
        $game  = $this->gameService->findData($gameId);

        $game->load( 'platforms', 'rarities');
        if ($gameId && ( !empty($game->platforms) || !empty($game->rarities))) {
            $this->selectedGameData =  $game;
            
            if ($this->selectedGameData) {
                $this->servers = $this->selectedGameData->servers ?? [];
                $this->factions = $this->selectedGameData->factions ?? [];
                $this->deliveryMethods = $this->selectedGameData->deliveryMethods ?? [];
            }
        } else {
            $this->selectedGameData = null;
            $this->servers = [];
            $this->factions = [];
            $this->deliveryMethods = [];
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
        $this->validate([
            'selectedGame' => 'required',
            'selectedServer' => 'required',
            'selectedFaction' => 'required',
            'selectedDeliveryMethod' => 'required',
        ]);

        // Ekhane database e save korbe
        // Offer::create([...]);

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
        $categories = $this->categoryService->getAllDatas();
        return view('livewire.backend.user.offers.offer', [
            'categories' => $categories
        ]);
    }
}
