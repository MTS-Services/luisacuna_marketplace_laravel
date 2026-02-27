<?php

namespace Tests\Feature;

use App\Enums\GameStatus;
use App\Enums\LanguageStatus;
use App\Livewire\Frontend\Partials\HeaderDropdown;
use App\Models\Category;
use App\Models\Game;
use App\Models\GameTranslation;
use App\Models\Language;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class HeaderDropdownSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_games_in_category_are_returned_even_if_not_popular(): void
    {
        $language = Language::factory()->create([
            'locale' => 'en',
            'status' => LanguageStatus::ACTIVE,
            'is_active' => true,
        ]);

        app()->setLocale($language->locale);

        $category = Category::factory()->create();

        $popularTag = Tag::factory()->create([
            'slug' => 'popular',
        ]);

        $popularGame = Game::factory()->create([
            'status' => GameStatus::ACTIVE,
        ]);

        $regularGame = Game::factory()->create([
            'status' => GameStatus::ACTIVE,
        ]);

        $category->games()->attach([$popularGame->id, $regularGame->id]);

        $popularGame->tags()->attach($popularTag->id);

        GameTranslation::factory()->create([
            'language_id' => $language->id,
            'game_id' => $popularGame->id,
            'name' => 'Popular Game',
        ]);

        GameTranslation::factory()->create([
            'language_id' => $language->id,
            'game_id' => $regularGame->id,
            'name' => 'Regular Game',
        ]);

        $component = Livewire::test(HeaderDropdown::class)
            ->set('gameCategorySlug', $category->slug);

        $content = $component->viewData('content');

        static::assertCount(1, $content['popular']);

        static::assertCount(2, $content['all']);
    }

    public function test_search_matches_translated_names_within_category(): void
    {
        $language = Language::factory()->create([
            'locale' => 'en',
            'status' => LanguageStatus::ACTIVE,
            'is_active' => true,
        ]);

        app()->setLocale($language->locale);

        $category = Category::factory()->create();

        $game = Game::factory()->create([
            'name' => 'Base Name',
            'status' => GameStatus::ACTIVE,
        ]);

        $category->games()->attach($game->id);

        GameTranslation::factory()->create([
            'language_id' => $language->id,
            'game_id' => $game->id,
            'name' => 'Translated Searchable Name',
        ]);

        $component = Livewire::test(HeaderDropdown::class)
            ->set('gameCategorySlug', $category->slug)
            ->set('search', 'Searchable');

        $content = $component->viewData('content');

        static::assertCount(1, $content['all']);
        static::assertSame($game->id, $content['all']->first()->id);
    }
}
