<?php

namespace App\Livewire\Backend\User\Offers;

use App\Models\Category;
use App\Models\Game;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class OfferGameSelect extends Component
{
    #[Locked]
    public string $categorySlug;

    #[Locked]
    public string $categoryName;

    public ?int $gameId = null;

    public function mount(string $categorySlug, string $categoryName): void
    {
        $this->categorySlug = $categorySlug;
        $this->categoryName = $categoryName;
    }

    public function selectGame(): mixed
    {
        $this->validate(
            ['gameId' => 'required'],
            ['gameId.required' => __('Please select a game before continuing.')],
        );

        $game = Game::findOrFail($this->gameId);

        return $this->redirect(
            route('user.offers.create.form', [$this->categorySlug, $game->slug]),
            navigate: false,
        );
    }

    public function render(): View
    {
        $category = Category::where('slug', $this->categorySlug)->active()->firstOrFail();

        $games = $category->games()->orderBy('name')->get();

        return view('livewire.backend.user.offers.offer-game-select', [
            'games' => $games,
        ]);
    }
}
