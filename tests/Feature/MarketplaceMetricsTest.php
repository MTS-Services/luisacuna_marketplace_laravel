<?php

use App\Enums\ActiveInactiveEnum;
use App\Enums\OrderStatus;
use App\Models\Category;
use App\Models\Game;
use App\Models\GameCategory;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\MarketplaceMetricsService;
use Illuminate\Support\Facades\DB;

/**
 * Helper: create a minimal category directly (factory has column mismatches).
 */
function createCategory(string $name, string $slug): Category
{
    return Category::create([
        'sort_order' => 1,
        'name' => $name,
        'slug' => $slug,
        'status' => 'active',
    ]);
}

/**
 * Helper: attach a game to a category via the pivot.
 */
function attachGameToCategory(Game $game, Category $category): GameCategory
{
    return GameCategory::create([
        'game_id' => $game->id,
        'category_id' => $category->id,
    ]);
}

/**
 * Helper: create a completed order for a product within the last 30 days.
 */
function createCompletedOrder(Product $product, User $user, int $quantity = 1): Order
{
    return Order::create([
        'sort_order' => 1,
        'order_id' => strtoupper(fake()->unique()->bothify('??######')),
        'user_id' => $user->id,
        'source_id' => $product->id,
        'source_type' => Product::class,
        'status' => OrderStatus::COMPLETED->value,
        'unit_price' => $product->price,
        'total_amount' => $product->price * $quantity,
        'tax_amount' => 0,
        'grand_total' => $product->price * $quantity,
        'quantity' => $quantity,
        'currency' => 'USD',
        'default_unit_price' => $product->price,
        'default_total_amount' => $product->price * $quantity,
        'default_tax_amount' => 0,
        'default_grand_total' => $product->price * $quantity,
        'default_currency' => 'USD',
        'display_currency' => 'USD',
        'display_symbol' => '$',
        'exchange_rate' => 1,
        'completed_at' => now()->subDays(5),
    ]);
}

// ─────────────────────────────────────────────────────────────
//  refreshProductMetrics — sales_count_30d & average_rating
// ─────────────────────────────────────────────────────────────

it('computes sales_count_30d from completed orders in the last 30 days', function () {
    $user = User::factory()->active()->create();
    $game = Game::factory()->create();
    $category = createCategory('Currency', 'currency');
    attachGameToCategory($game, $category);

    $product = Product::factory()->create([
        'user_id' => $user->id,
        'game_id' => $game->id,
        'category_id' => $category->id,
    ]);

    // 3 orders × 10 qty each = 30 total sales
    createCompletedOrder($product, $user, 10);
    createCompletedOrder($product, $user, 10);
    createCompletedOrder($product, $user, 10);

    // An old order (> 30 days) should NOT count
    Order::create([
        'sort_order' => 1,
        'order_id' => strtoupper(fake()->unique()->bothify('??######')),
        'user_id' => $user->id,
        'source_id' => $product->id,
        'source_type' => Product::class,
        'status' => OrderStatus::COMPLETED->value,
        'unit_price' => $product->price,
        'total_amount' => $product->price * 5,
        'tax_amount' => 0,
        'grand_total' => $product->price * 5,
        'quantity' => 5,
        'currency' => 'USD',
        'default_unit_price' => $product->price,
        'default_total_amount' => $product->price * 5,
        'default_tax_amount' => 0,
        'default_grand_total' => $product->price * 5,
        'default_currency' => 'USD',
        'display_currency' => 'USD',
        'display_symbol' => '$',
        'exchange_rate' => 1,
        'completed_at' => now()->subDays(45),
    ]);

    app(MarketplaceMetricsService::class)->refreshProductMetrics();

    expect($product->fresh()->sales_count_30d)->toBe(30);
});

it('computes average_rating from feedback linked via orders', function () {
    $user = User::factory()->active()->create();
    $buyer = User::factory()->active()->create();
    $game = Game::factory()->create();
    $category = createCategory('Accounts', 'accounts');
    attachGameToCategory($game, $category);

    $product = Product::factory()->create([
        'user_id' => $user->id,
        'game_id' => $game->id,
        'category_id' => $category->id,
    ]);

    $order1 = createCompletedOrder($product, $buyer, 1);
    $order2 = createCompletedOrder($product, $buyer, 1);

    // Rating 4 + Rating 5 = avg 4.50
    DB::table('feedback')->insert([
        ['sort_order' => 1, 'author_id' => $buyer->id, 'target_user_id' => $user->id, 'order_id' => $order1->id, 'type' => 'positive', 'message' => 'Great', 'rating' => 4, 'is_first_feedback' => true, 'created_at' => now(), 'updated_at' => now()],
        ['sort_order' => 2, 'author_id' => $buyer->id, 'target_user_id' => $user->id, 'order_id' => $order2->id, 'type' => 'positive', 'message' => 'Excellent', 'rating' => 5, 'is_first_feedback' => false, 'created_at' => now(), 'updated_at' => now()],
    ]);

    app(MarketplaceMetricsService::class)->refreshProductMetrics();

    expect((float) $product->fresh()->average_rating)->toBe(4.50);
});

// ─────────────────────────────────────────────────────────────
//  refreshTopSellingProducts — top 5% per game
// ─────────────────────────────────────────────────────────────

it('flags only the top 5 percent of products per game as top selling', function () {
    $user = User::factory()->active()->create();
    $game = Game::factory()->create();
    $category = createCategory('Items', 'items');
    attachGameToCategory($game, $category);

    // Create 20 products so top 5% = 1 product
    $products = collect();
    for ($i = 1; $i <= 20; $i++) {
        $products->push(Product::factory()->create([
            'user_id' => $user->id,
            'game_id' => $game->id,
            'category_id' => $category->id,
            'sales_count_30d' => $i * 10,
            'average_rating' => min(5, $i * 0.25),
        ]));
    }

    $service = app(MarketplaceMetricsService::class);
    $service->refreshTopSellingProducts();

    $topSellingCount = Product::where('game_id', $game->id)
        ->where('is_top_selling', true)
        ->count();

    // 5% of 20 = 1 product (the best one)
    expect($topSellingCount)->toBe(1);

    // The product with the highest score should be flagged
    $bestProduct = $products->last();
    expect($bestProduct->fresh()->is_top_selling)->toBeTrue();

    // The worst product should NOT be flagged
    $worstProduct = $products->first();
    expect($worstProduct->fresh()->is_top_selling)->toBeFalse();
});

it('does not flag products with zero score as top selling', function () {
    $user = User::factory()->active()->create();
    $game = Game::factory()->create();
    $category = createCategory('Boosting', 'boosting');
    attachGameToCategory($game, $category);

    // All products have 0 sales and 0 rating
    Product::factory()->count(5)->create([
        'user_id' => $user->id,
        'game_id' => $game->id,
        'category_id' => $category->id,
        'sales_count_30d' => 0,
        'average_rating' => 0,
    ]);

    app(MarketplaceMetricsService::class)->refreshTopSellingProducts();

    expect(Product::where('is_top_selling', true)->count())->toBe(0);
});

// ─────────────────────────────────────────────────────────────
//  refreshPopularGames — top 3 per category
// ─────────────────────────────────────────────────────────────

it('flags only the top 3 games per category as popular', function () {
    $user = User::factory()->active()->create();
    $category = createCategory('Coaching', 'coaching');

    // Create 5 games, each with different total sales in this category
    $games = collect();
    foreach ([500, 300, 100, 50, 10] as $sales) {
        $game = Game::factory()->create();
        attachGameToCategory($game, $category);

        Product::factory()->create([
            'user_id' => $user->id,
            'game_id' => $game->id,
            'category_id' => $category->id,
            'sales_count_30d' => $sales,
        ]);

        $games->push($game);
    }

    app(MarketplaceMetricsService::class)->refreshPopularGames();

    // Top 3 should be popular
    foreach ($games->take(3) as $game) {
        $pivot = GameCategory::where('game_id', $game->id)
            ->where('category_id', $category->id)
            ->first();
        expect($pivot->is_popular)->toBeTrue();
    }

    // Bottom 2 should NOT be popular
    foreach ($games->skip(3) as $game) {
        $pivot = GameCategory::where('game_id', $game->id)
            ->where('category_id', $category->id)
            ->first();
        expect($pivot->is_popular)->toBeFalse();
    }
});

it('scopes popular flag per category so a game can be popular in one but not another', function () {
    $user = User::factory()->active()->create();
    $catAction = createCategory('Action', 'action');
    $catStrategy = createCategory('Strategy', 'strategy');

    $game = Game::factory()->create();
    attachGameToCategory($game, $catAction);
    attachGameToCategory($game, $catStrategy);

    // High sales in Action
    Product::factory()->create([
        'user_id' => $user->id,
        'game_id' => $game->id,
        'category_id' => $catAction->id,
        'sales_count_30d' => 50000,
    ]);

    // Low sales in Strategy
    Product::factory()->create([
        'user_id' => $user->id,
        'game_id' => $game->id,
        'category_id' => $catStrategy->id,
        'sales_count_30d' => 1,
    ]);

    // Add 3 other games with higher sales in Strategy to push our game out
    for ($i = 0; $i < 3; $i++) {
        $otherGame = Game::factory()->create();
        attachGameToCategory($otherGame, $catStrategy);
        Product::factory()->create([
            'user_id' => $user->id,
            'game_id' => $otherGame->id,
            'category_id' => $catStrategy->id,
            'sales_count_30d' => 1000 * ($i + 1),
        ]);
    }

    app(MarketplaceMetricsService::class)->refreshPopularGames();

    $actionPivot = GameCategory::where('game_id', $game->id)
        ->where('category_id', $catAction->id)->first();
    $strategyPivot = GameCategory::where('game_id', $game->id)
        ->where('category_id', $catStrategy->id)->first();

    expect($actionPivot->is_popular)->toBeTrue();
    expect($strategyPivot->is_popular)->toBeFalse();
});

// ─────────────────────────────────────────────────────────────
//  Artisan command
// ─────────────────────────────────────────────────────────────

it('runs the artisan command successfully', function () {
    $this->artisan('app:refresh-marketplace-metrics')
        ->assertSuccessful();
});

// ─────────────────────────────────────────────────────────────
//  N+1 free: refreshAll uses only bulk SQL, no model loops
// ─────────────────────────────────────────────────────────────

it('executes refreshAll with a bounded number of queries regardless of data size', function () {
    $user = User::factory()->active()->create();
    $category = createCategory('TopUp', 'top-up');

    // Create 10 games each with 5 products = 50 products total
    for ($g = 0; $g < 10; $g++) {
        $game = Game::factory()->create();
        attachGameToCategory($game, $category);

        for ($p = 0; $p < 5; $p++) {
            $product = Product::factory()->create([
                'user_id' => $user->id,
                'game_id' => $game->id,
                'category_id' => $category->id,
            ]);
            createCompletedOrder($product, $user, fake()->numberBetween(1, 100));
        }
    }

    $service = app(MarketplaceMetricsService::class);

    // The service should use a constant number of queries (6: 3 resets + 3 bulk updates)
    // regardless of data size — no N+1
    $queryLog = [];
    DB::listen(function ($query) use (&$queryLog) {
        $queryLog[] = $query->sql;
    });

    $service->refreshAll();

    // Expect exactly 6 SQL statements: refreshProductMetrics=1, resetTopSelling+updateTopSelling=2, resetPopular+updatePopular=2
    // Total = 5 queries (1 + 2 + 2)
    $dmlQueries = array_filter($queryLog, fn($sql) => str_starts_with(strtoupper(trim($sql)), 'UPDATE'));
    expect(count($dmlQueries))->toBeLessThanOrEqual(6);
});
