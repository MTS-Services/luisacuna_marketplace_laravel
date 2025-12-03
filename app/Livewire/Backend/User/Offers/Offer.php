<?php

namespace App\Livewire\Backend\User\Offers;

use App\Models\Product;
use Livewire\Component;
use App\Services\GameService;
use App\Services\CategoryService;

class Offer extends Component
{
    public $step = 1;
    public $selectedCategory = null;
    public $selectedCategoryId = null;
    public $categoryGames = [];
    public $selectedGame = null;
    public $selectedGameData = null;
    public $selectedDeliveryMethod;
    public $price;
    public $stock_quantity;
    public $Platform;
    public $description;

    // Dynamic configuration fields
    public $gameConfigs = [];
    public $configValues = [];
    public $deliveryMethods = [];

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

        session([
            'selectedCategoryId' => $categoryId,
            'selectedCategoryName' => $categoryName,
        ]);

        $this->step = 2;
    }

    public function updatedSelectedGame($gameId)
    {
        // Reset previous selections
        $this->configValues = [];
        $this->deliveryMethods = [];
        if ($gameId) {

            $game = $this->gameService->findData($gameId);

            $game->load('gameConfig');

            $this->gameConfigs = $game->gameConfig;

            $this->selectedGameData = $game;



            $deliveryGroups = [];
            foreach ($game->gameConfig as $config) {
                $methods = json_decode($config->delivery_methods, true);
                if ($methods) {
                    foreach ($methods as $m) {
                        $deliveryGroups[$m['value']] = $m['label'];
                    }
                }
            }

            $this->deliveryMethods = $deliveryGroups;

            session(['selectedGameId' => $gameId]);
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
        // Retrieve data from session
        $categoryId = session('selectedCategoryId', $this->selectedCategoryId);
        $gameId = session('selectedGameId', $this->selectedGame);

        Product::create([
            'user_id' => auth()->id(),
            'category_id' => $categoryId,
            'game_id' => $gameId,
            'config_values' => json_encode($this->configValues), // Dynamic attributes
            'delivery_method' => $this->selectedDeliveryMethod,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'platform' => $this->Platform,
            'description' => $this->description,
        ]);

        // Flash message
        session()->flash('message', 'Offer successfully created!');

        // Reset properties
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
