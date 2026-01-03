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

        $query = Game::query();

        $query->with(['tags', 'categories', 'gameTranslations' => function ($query) {
                $query->where('language_id', get_language_id());
            }])
            ->active()
            ->whereHas('categories', function ($query) use ($category) {
                    $query->where('categories.id', $category->id);
            })
            ->orderBy('name', 'asc');
        // Get games with 'popular' tag for this category
        $popularGames = clone $query->whereHas('tags', function ($query) {
                $query->where('tags.slug', 'popular'); // or use tag name/id
            })
            ->take(12)
            ->get();

        // Get all games for this category (for the sidebar)
         $allGames = clone $query->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->get();

            return [
                'popular' => $popularGames,
                'all' => $allGames,
            ];

    }
    public function render()
    {
       
        return view('livewire.frontend.partials.header-dropdown');
    }
}