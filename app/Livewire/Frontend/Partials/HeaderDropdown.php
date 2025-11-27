<?php

namespace App\Livewire\Frontend\Partials;

use Livewire\Component;
use App\Models\Category;
use App\Models\Game;

class HeaderDropdown extends Component
{
    public $gameCategorySlug = '';
    public $search = '';

    protected $loaded = [];

    protected $listeners = ['setGameCategorySlug'];

    public function setGameCategorySlug($gameCategorySlug)
    {
        if (!isset($this->loaded[$gameCategorySlug])) {
            $this->gameCategorySlug = $gameCategorySlug;
            $this->loaded[$gameCategorySlug] = true;
        } else {
            $this->gameCategorySlug = $gameCategorySlug;
        }
    }
    
    public function getContentProperty()
    {
        if (empty($this->gameCategorySlug)) {
            return ['popular' => [], 'all' => []];
        }

        // Get the category by slug
        $category = Category::where('slug', $this->gameCategorySlug)
            ->active()
            ->first();

        if (!$category) {
            return ['popular' => [], 'all' => []];
        }

        // Get games with 'popular' tag for this category
        $popularGames = Game::whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category->id);
            })
            ->whereHas('tags', function ($query) {
                $query->where('tags.slug', 'popular'); // or use tag name/id
            })
            ->active()
            ->with(['tags', 'categories'])
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get()
            ->map(function ($game) {
                return [
                    'name' => $game->name,
                    'logo' => $game->logo, 
                    'slug' => $game->slug,
                ];
            });
        // Get all games for this category (for the sidebar)
         $allGames = Game::whereHas('categories', function ($query) use ($category) {
                    $query->where('categories.id', $category->id);
                })
                ->active()
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($game) {
                    return [
                        'name' => $game->name,
                        'slug' => $game->slug,
                        'logo' => $game->logo, // null or path
                    ];
                })
                ->toArray();

            return [
                'popular' => $popularGames->toArray(),
                'all' => $allGames,
            ];

    }
    public function render()
    {
       
        return view('livewire.frontend.partials.header-dropdown');
    }
}