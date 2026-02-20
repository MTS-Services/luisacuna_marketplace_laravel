<?php

namespace App\Http\Controllers\Backend\User\OfferManagement;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Game;
use Illuminate\View\View;

class OfferController extends Controller
{
    protected string $masterView = 'backend.user.pages.offer-management.offer';

    public function create(): View
    {
        return view($this->masterView, ['step' => 'category']);
    }

    public function gameSelect(string $categorySlug): View
    {
        $category = Category::where('slug', $categorySlug)->active()->firstOrFail();

        return view($this->masterView, [
            'step' => 'game',
            'categorySlug' => $category->slug,
            'categoryName' => $category->name,
        ]);
    }

    public function productForm(string $categorySlug, string $gameSlug): View
    {
        $category = Category::where('slug', $categorySlug)->active()->firstOrFail();
        $game = Game::where('slug', $gameSlug)
            ->whereHas('categories', fn ($q) => $q->where('categories.id', $category->id))
            ->firstOrFail();

        return view($this->masterView, [
            'step' => 'form',
            'categorySlug' => $category->slug,
            'gameSlug' => $game->slug,
        ]);
    }

    public function edit(string $encrypted_id): View
    {
        return view($this->masterView, compact('encrypted_id'));
    }
}
