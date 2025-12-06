<?php

namespace App\Livewire\Backend\User\Offers;

use App\Models\Game;
use App\Models\Product;
use Livewire\Component;
use App\Services\GameService;
use App\Services\CategoryService;

class Offer extends Component
{

    //Public Variable 

    public $step = 1;

    public $categoryId = null;
    public $categoryName = null;
    public $gameId = null;
    public $deliveryMethod = null;
    public $platform = null;
    public $price = null;
    public $stock_quantity = null;
    public $description = null;


    // Dynamic Variable Just for demostration , if it store in another table then remove this code .
    // Dynamic varibale created by "config_". game_confisg's slug but if slug contains '-' it will replace by "_".

    public $config_server;
    public $config_faction;
    public $config_number_of_skin;
    public $config_rare_skin; 


    //Load Services

    protected CategoryService $categoryService;
    protected GameService $gameService;


    //Data Collections

    public $games;

    // When A single Game selected will store the data to $game
    public Game $game;


    // Dynamic Configs Data need to create offer
     public $gameConfigs;

     public $platforms;

     public $servers;

     public $deliveryMethods;





    public function boot(CategoryService $categoryService, GameService $gameService)
    {
        $this->categoryService = $categoryService;
        $this->gameService = $gameService;
    }

    // When Select Category will run Select Category with category id and name
    public function selectCategory($categoryId, $categoryName)
    {
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;


        $category = $this->categoryService->findData($categoryId)->load('games');

        $this->games = $category->games ;

        $this->step = 2;
    }

    // When Select Game it will go next with game id

    public function selectGame()
    {
        $this->validate([
            'gameId' => 'required',
        ],
        [
        'gameId.required' => 'Please select a game before continuing.',
        ]
        );

        $this->updatedSelectedGame($this->gameId);

        $this->step = 3;
    }

    // Must call this with game id to create next step

       public function updatedSelectedGame($gameId)
    {


        if ($gameId) {
    
            $game = $this->gameService->findData($gameId);
            
            $this->game = $game;
            
            $game->load('gameConfig', 'platforms');

            $this->gameConfigs = $game->gameConfig;

            $this->platforms = $game->platforms;

            $this->deliveryMethods = json_decode($game->gameConfig->first()->delivery_methods, true);

        } else {
           return ;
        }
    }

    

    public function submitOffer()
    {
        // For Test
        // $arr = [
        //     'game_id' => $this->gameId,
        //     'category_id' => $this->categoryId,
        //     'delivery_method' => $this->deliveryMethod,
        //     'platform'=> $this->platform,
        //     'price' => $this->price,
        //     'stock_quantity' => $this->stock_quantity,
        //     'description' => $this->description,
        //     'config_server' => $this->config_server,
        //     'config_faction' => $this->config_faction,
        //     'config_number_of_skin' => $this->config_number_of_skin,
        //     'config_rare_skin' => $this->config_rare_skin
            
        // ];


      $data = $this->validate(
            [
                'gameId' => 'required|integer',
                'categoryId' => 'required|integer',
                'deliveryMethod' => 'required|string|max:255',
                'platform' => 'nullable|string|max:255',
                'price' => 'required|numeric|min:1',
                'stock_quantity' => 'required|integer|min:1',
                'description' => 'nullable',

                'config_server' => 'required|string|max:255',
                'config_faction' => 'required|string|max:255',
                'config_number_of_skin' => 'required|integer|min:1',
                'config_rare_skin' => 'required|string|max:255',
            ],
            [
                'gameId.required' => 'Please select a game.',
                'categoryId.required' => 'Category is required.',
                'deliveryMethod.required' => 'Please select a delivery method.',
                'platform.required' => 'Platform is required.',
                'price.required' => 'Price is required.',
            ]

        );

       

   
        // Flash message
        session()->flash('message', 'Offer successfully created!');

        // Reset properties
        $this->resetField();
    }


    public function render()
    {
        $categories = $this->categoryService->getDatas();

        return view('livewire.backend.user.offers.offer', [
            'categories' => $categories
        ]);
    }

    // Existing



    public function back()
    {
        if ($this->step > 1) {
            $this->step--;
        }
        $this->resetField();
    }

    public function resetField(){

        $this->gameId = null;
        $this->categoryId = null;
        $this->deliveryMethod = null;
        $this->platform = null;
        $this->price = null;
        $this->stock_quantity = null;
        $this->description = null;

        //Dynamic Fields

        $this->config_server = null;
        $this->config_faction = null;
        $this->config_number_of_skin = null;
        $this->config_rare_skin = null;
    }

    public function serachFilter(){}

}
